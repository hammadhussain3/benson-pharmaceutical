<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RawMaterialItem;

class InvoiceService
{
    public function getAllInvoices($type)
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $invoices = Invoice::where('type', $type)->latest()->get();
        } else {
            $invoices = Invoice::where('type', $type)->where('company_id', auth()->user()->employee->company_id)->latest()->get();
        }
        return $invoices;
    }

    public function createInvoice(array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice = Invoice::create($data);

        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $key => $value) {
                $value['product_variation_id'] = isset($value['product']) ? $value['product'] : null;
                $value['raw_material_item_id'] = isset($value['raw_material_item']) ? $value['raw_material_item'] : null;
                $value['batch_id'] = isset($value['batch']) ? $value['batch'] : null;
                $invoice->items()->create($value);
            }
        }
        return $data;
    }

    public function updateInvoice(Invoice $invoice, array $data)
    {
        $data['party_id'] = $data['party'];
        $data['company_id'] = $data['company'];
        $invoice->update($data);
        $invoice->items()->delete();
        if ($data['invoice_items']) {
            foreach ($data['invoice_items'] as $value) {
                $value['product_variation_id'] = isset($value['product']) ? $value['product'] : null;
                $value['raw_material_item_id'] = isset($value['raw_material_item']) ? $value['raw_material_item'] : null;
                $value['batch_id'] = isset($value['batch']) ? $value['batch'] : null;
                $invoice->items()->create($value);
            }
        }
        return $data;
    }

    public function deleteInvoice(Invoice $invoice)
    {
        return $invoice->delete();
    }

    public function getInvoiceById($id)
    {
        return Invoice::findOrFail($id);
    }

    public function createInvoiceCode($company_id, $type)
    {
        $prefix = $type == 'sale' ? 'SI' : ($type == 'purchase' ? 'PR' : ($type == 'quotation' ? 'QT' : ''));
        $lastInvoiceCode = Invoice::latest('id')->where('prefix', $prefix)->where('company_id', $company_id)->value('code');
        if ($lastInvoiceCode) {
            $numberPart = (int) substr($lastInvoiceCode, 2);
            $newNumberPart = $numberPart + 1;
            $newInvoiceCode = $prefix . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newInvoiceCode = $prefix . '00001';
        }
        return $newInvoiceCode;
    }

    public function getOnlyPurchaseItems($from_date, $to_date, $status)
    {
        $invoiceItemQuery = InvoiceItem::whereHas('invoice', function ($query) use ($from_date, $to_date) {
            $query->where('type', 'purchase')
                ->whereBetween('invoice_date', [$from_date, $to_date]);
        });

        if (!auth()->user()->hasRole('Superadmin')) {
            $invoiceItemQuery->whereHas('invoice', function ($query) {
                $query->where('company_id', auth()->user()->employee->company_id);
            });
        }

        $invoiceItems = $invoiceItemQuery
            ->with([
                'invoice' => function ($query) {
                    $query->select('id', 'code', 'invoice_date', 'required_date', 'status', 'company_id');
                },
                'rawMaterialItem' => function ($query) {
                    $query->select('id', 'code', 'name');
                }
            ])
            ->select('id', 'invoice_id', 'raw_material_item_id', 'quantity')
            ->get();

        $filteredItems = $invoiceItems->filter(function ($invoiceItem) use ($status) {
            $receivedQuantity = 0;

            if ($invoiceItem->invoice->goodsReceivings) {
                $receivedQuantity = $invoiceItem->invoice->goodsReceivings->flatMap(function ($goodsReceiving) {
                    return $goodsReceiving->items;
                })
                ->filter(function ($goodsReceivingItem) use ($invoiceItem) {
                    return $goodsReceivingItem->product_id === $invoiceItem->product_id ||
                        $goodsReceivingItem->raw_material_item_id === $invoiceItem->raw_material_item_id;
                })
                ->sum('balance_receivable');
            }

            $invoiceItem->received_quantity = $receivedQuantity;
            $invoiceItem->status = $invoiceItem->quantity != $receivedQuantity ? 'Pending' : 'Completed';
            $invoiceItem->item_code = $invoiceItem->product->code ?? $invoiceItem->rawMaterialItem->code;

            return $status === null || $invoiceItem->status === $status;
        });

        return $filteredItems->values();
    }

    public function getOnlyPurchaseRequisitions($from_date, $to_date, $status)
    {
        $invoiceQuery = Invoice::where('type', 'purchase')
            ->whereBetween('invoice_date', [$from_date, $to_date])
            ->orderBy('required_date', 'asc');

        if (!auth()->user()->hasRole('Superadmin')) {
            $invoiceQuery->where('company_id', auth()->user()->employee->company_id);
        }

        if ($status != null) {
            $invoiceQuery->where('status', $status);
        }

        $invoices = $invoiceQuery
            ->with([
                'items' => function ($query) {
                    $query->select('id', 'invoice_id', 'raw_material_item_id', 'quantity');  // Select only necessary invoice item columns
                },
                'items.rawMaterialItem' => function ($query) {
                    $query->select('id', 'code', 'name');
                },
                'goodsReceivings' => function ($query) {
                    $query->select('invoice_id');
                }
            ])
            ->select('id', 'code', 'invoice_date', 'required_date', 'status', 'company_id')  // Select only necessary invoice columns
            ->get();

        $invoices->each(function ($invoice) {
            $invoice->items->each(function ($invoiceItem) use ($invoice) {
                $receivedQuantity = 0;
                if ($invoiceItem->invoice->goodsReceivings) {
                    $receivedQuantity = $invoiceItem->invoice->goodsReceivings->flatMap(function ($goodsReceiving) {
                        return $goodsReceiving->items;
                    })
                    ->filter(function ($goodsReceivingItem) use ($invoiceItem) {
                        return $goodsReceivingItem->product_id === $invoiceItem->product_id ||
                            $goodsReceivingItem->raw_material_item_id === $invoiceItem->raw_material_item_id;
                    })
                    ->sum('balance_receivable');
                }
    
                $invoiceItem->received_quantity = $receivedQuantity;
                $invoiceItem->item_code = $invoiceItem->product->code ?? $invoiceItem->rawMaterialItem->code;
                $invoiceItem->item_name = $invoiceItem->product->name ?? $invoiceItem->rawMaterialItem->name;
            });
        });

        return $invoices;
    }

    public function getRequirementForInvoice()
    {
        $products = RawMaterialItem::all();

        if (!auth()->user()->hasRole('Superadmin')) {
            $products = $products->where('company_id', auth()->user()->employee->company_id);
        }

        $products->each(function ($product) {
            $orderedItems = $product->orders()->whereHas('invoice', function ($query) {
                $query->where('status', 'pending');
            })->with([
                'invoice' => function ($query) {
                    $query->select('id', 'code');
                },
            ])->select('id', 'invoice_id', 'quantity')
            ->get();

            $uniqueInvoiceIds = $orderedItems->pluck('invoice_id')->unique();

            $uniqueInvoiceIds->each(function ($invoiceId) use ($orderedItems, $product) {
                $invoiceItems = $orderedItems->filter(function ($orderedItem) use ($invoiceId) {
                    return $orderedItem->invoice_id == $invoiceId;
                });

                $received_quantity = 0;
                $invoiceItems->each(function ($orderedItem) use ($product, &$received_quantity) {
                    if ($orderedItem->invoice->goodsReceivings) {
                        $received_quantity += $orderedItem->invoice->goodsReceivings->flatMap(function ($goodsReceiving) {
                            return $goodsReceiving->items;
                        })->filter(function ($goodsReceivingItem) use ($product) {
                            return $goodsReceivingItem->raw_material_item_id === $product->id;
                        })->sum('balance_receivable');
                    }
                });

                $product->received_quantity = $received_quantity;

                $invoice_codes = $invoiceItems->pluck('invoice.code')->unique()->toArray();
                $product->invoice_codes = $invoice_codes;
            });

            $product->ordered_quantity = $orderedItems->sum('quantity');
        });

        return $products;
    }
}