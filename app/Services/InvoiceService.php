<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\RawMaterialItem;
use App\Models\Stock;

class InvoiceService
{
    public function getAllInvoices()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $invoices = Invoice::orderBy('required_date', 'asc')->get();
        } else {
            $invoices = Invoice::where('company_id', auth()->user()->employee->company_id)->orderBy('required_date', 'asc')->get();
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
                $value['invoice_id'] = $invoice->id;
                if (str_starts_with($value['product'], 'product_')) {
                    $value['product_id'] = str_replace('product_', '', $value['product']);
                    $value['raw_material_item_id'] = null;
                } elseif (str_starts_with($value['product'], 'raw_')) {
                    $value['raw_material_item_id'] = str_replace('raw_', '', $value['product']);
                    $value['product_id'] = null;
                }
                InvoiceItem::create($value);
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
                $value['invoice_id'] = $invoice->id;
                if (str_starts_with($value['product'], 'product_')) {
                    $value['product_id'] = str_replace('product_', '', $value['product']);
                    $value['raw_material_item_id'] = null;
                } elseif (str_starts_with($value['product'], 'raw_')) {
                    $value['raw_material_item_id'] = str_replace('raw_', '', $value['product']);
                    $value['product_id'] = null;
                }
                InvoiceItem::create($value);
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

    public function getOnlyPurchaseItems()
    {
        $invoiceItemQuery = InvoiceItem::whereHas('invoice', function ($query) {
            $query->where('type', 'purchase');
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
                'product' => function ($query) {
                    $query->select('id', 'code', 'name');
                },
                'rawMaterialItem' => function ($query) {
                    $query->select('id', 'code', 'name');
                }
            ])
            ->select('id', 'invoice_id', 'product_id', 'raw_material_item_id', 'product_quantity')
            ->get();

        $invoiceItems->each(function ($invoiceItem) {
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
            $invoiceItem->status = $invoiceItem->product_quantity != $receivedQuantity ? 'Pending' : 'Completed';
            $invoiceItem->item_code = $invoiceItem->product->code ?? $invoiceItem->rawMaterialItem->code;
        });

        return $invoiceItems;
    }

    public function getOnlyPurchaseRequisitions()
    {
        // Query for purchase invoices, where type is 'purchase'
        $invoiceQuery = Invoice::where('type', 'purchase')->orderBy('required_date', 'asc');

        // Restrict access based on user role and company if not Superadmin
        if (!auth()->user()->hasRole('Superadmin')) {
            $invoiceQuery->where('company_id', auth()->user()->employee->company_id);
        }

        // Get the invoices data with related product and raw material item details
        $invoices = $invoiceQuery
            ->with([
                'items' => function ($query) {
                    $query->select('id', 'invoice_id', 'product_id', 'raw_material_item_id', 'product_quantity');  // Select only necessary invoice item columns
                },
                'items.product' => function ($query) {
                    $query->select('id', 'code', 'name');  // Select only necessary product columns
                },
                'items.rawMaterialItem' => function ($query) {
                    $query->select('id', 'code', 'name');  // Select only necessary raw material columns
                },
                'goodsReceivings' => function ($query) {
                    $query->select('invoice_id');  // Select only necessary goods receiving columns
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
            ])->select('id', 'invoice_id', 'product_quantity')
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

            $product->ordered_quantity = $orderedItems->sum('product_quantity');
        });

        return $products;
    }
}