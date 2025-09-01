<?php

namespace App\Services;

use App\Models\GoodsReceiving;
use App\Models\GoodsReceivingItem;
use App\Models\Invoice;

class GoodsReceivingService
{
    public function getAllGoodsReceivings()
    {
        if (auth()->user()->hasRole('Superadmin')) {
            $goodsReceivings = GoodsReceiving::orderBy('created_at', 'desc')->get();
        } else {
            $goodsReceivings = GoodsReceiving::where('company_id', auth()->user()->employee->company_id)->orderBy('created_at', 'desc')->get();
        }
        return $goodsReceivings;
    }

    // public function createGoodsReceiving(array $data)
    // {
    //     $data['invoice_id'] = $data['invoice'];
    //     $data['party_id'] = $data['supplier'];
    //     $data['company_id'] = $data['company'];

    //     $goodsReceiving = GoodsReceiving::create($data);

    //     $items = $data['items'] ?? [];

    //     foreach ($items as $item) {
    //         $grn_items = $item['grn_items'] ?? [];
    //         foreach ($grn_items as $key => $grn_item) {
    //             $grn_item['product_id'] = $item['product'] ?? null;
    //             $grn_item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
    //             $grn_item['code'] = $item['code'] ?? null;
    //             $grn_item['description'] = $item['description'] ?? null;
    //             $grn_item['quantity_ordered'] = $item['quantity_ordered'] ?? null;
    //             $grn_item['quantity_received'] = $item['quantity_received'] ?? null;
                
    //             if ($grn_item['product_id']) {
    //                 $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $grn_item['product_id'])
    //                     ->latest('id')
    //                     ->value('goods_receiving_id');
    //             } elseif ($grn_item['raw_material_item_id']) {
    //                 $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $grn_item['raw_material_item_id'])
    //                     ->latest('id')
    //                     ->value('goods_receiving_id');
    //             }

    //             $goodsReceiving->items()->create($grn_item);

    //             $grn_item['quantity'] = $grn_item['balance_receivable'];
    //             $grn_item['total'] = $grn_item['total_amount'];
    //             $grn_item['company_id'] = $data['company_id'];

    //             $goodsReceiving->stocks()->create($grn_item);
    //         }
    //     }

    //     $allItemsMatch = $goodsReceiving->items->every(function ($item) {
    //         return $item->quantity_ordered == ($item->quantity_received + $item->balance_receivable);
    //     });

    //     // Handle vendor bills
    //     if (isset($data['vendor_bills']) && is_array($data['vendor_bills'])) {
    //         foreach ($data['vendor_bills'] as $vendorBill) {
    //             $goodsReceiving->vendor_bills()->create([
    //                 'item_index' => $vendorBill['item_index'],
    //                 'bill_no' => $vendorBill['bill_no'],
    //                 'bill_date' => $vendorBill['bill_date'] ?? null,
    //                 'amount' => $vendorBill['amount'] ?? 0,
    //             ]);
    //         }
    //     }

    //     return $goodsReceiving;
    // }

    public function createGoodsReceiving(array $data)
    {
        $data['invoice_id'] = $data['invoice'];
        $data['party_id']   = $data['supplier'];
        $data['company_id'] = $data['company'];

        $goodsReceiving = GoodsReceiving::create($data);

        $items = $data['items'] ?? [];

        foreach ($items as $item) {
            $grn_items = $item['grn_items'] ?? [];

            foreach ($grn_items as $key => $grn_item) {
                $grn_item['product_id']         = $item['product'] ?? null;
                $grn_item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
                $grn_item['code']               = $item['code'] ?? null;
                $grn_item['description']        = $item['description'] ?? null;
                $grn_item['quantity_ordered']   = $item['quantity_ordered'] ?? null;
                $grn_item['quantity_received']  = $item['quantity_received'] ?? null;

                if ($grn_item['product_id']) {
                    $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $grn_item['product_id'])
                        ->latest('id')
                        ->value('goods_receiving_id');
                } elseif ($grn_item['raw_material_item_id']) {
                    $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $grn_item['raw_material_item_id'])
                        ->latest('id')
                        ->value('goods_receiving_id');
                }

                // Create Goods Receiving Item
                $goodsReceiving->items()->create($grn_item);

                // Create Stock entry
                $grn_item['quantity']   = $grn_item['balance_receivable'];
                $grn_item['total']      = $grn_item['total_amount'];
                $grn_item['company_id'] = $data['company_id'];

                $goodsReceiving->stocks()->create($grn_item);
            }
        }

        // ✅ Invoice Status Check
        $allCompleted = $goodsReceiving->items->every(function ($item) {
            return $item->quantity_ordered <= ($item->quantity_received + $item->balance_receivable);
        });

        $status = $allCompleted ? 'COMPLETED' : 'PARTIALLY COMPLETE';

        // Update Invoice status
        Invoice::where('id', $goodsReceiving->invoice_id)->update([
            'status' => $status,
        ]);

        // Handle vendor bills
        if (isset($data['vendor_bills']) && is_array($data['vendor_bills'])) {
            foreach ($data['vendor_bills'] as $vendorBill) {
                $goodsReceiving->vendor_bills()->create([
                    'item_index' => $vendorBill['item_index'],
                    'bill_no'    => $vendorBill['bill_no'],
                    'bill_date'  => $vendorBill['bill_date'] ?? null,
                    'amount'     => $vendorBill['amount'] ?? 0,
                ]);
            }
        }

        return $goodsReceiving;
    }


    // public function updateGoodsReceiving(GoodsReceiving $goodsReceiving, array $data)
    // {
    //     $data['invoice_id'] = $data['invoice'];
    //     $data['party_id'] = $data['supplier'];
    //     $data['company_id'] = $data['company'];

    //     $goodsReceiving->update($data);

    //     $goodsReceiving->stocks->each->delete();
    //     $goodsReceiving->items->each->delete();

    //     $items = $data['items'] ?? [];

    //     foreach ($items as $item) {
    //         $grn_items = $item['grn_items'] ?? [];
    //         foreach ($grn_items as $key => $grn_item) {
    //             $grn_item['product_id'] = $item['product'] ?? null;
    //             $grn_item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
    //             $grn_item['code'] = $item['code'] ?? null;
    //             $grn_item['description'] = $item['description'] ?? null;
    //             $grn_item['quantity_ordered'] = $item['quantity_ordered'] ?? null;
    //             $grn_item['quantity_received'] = $item['quantity_received'] ?? null;
                
    //             if ($grn_item['product_id']) {
    //                 $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $grn_item['product_id'])
    //                     ->latest('id')
    //                     ->value('goods_receiving_id');
    //             } elseif ($grn_item['raw_material_item_id']) {
    //                 $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $grn_item['raw_material_item_id'])
    //                     ->latest('id')
    //                     ->value('goods_receiving_id');
    //             }

    //             $goodsReceiving->items()->create($grn_item);

    //             $grn_item['quantity'] = $grn_item['balance_receivable'];
    //             $grn_item['total'] = $grn_item['total_amount'];
    //             $grn_item['company_id'] = $data['company_id'];

    //             $goodsReceiving->stocks()->create($grn_item);
    //         }
    //     }

    //     $allItemsMatch = $goodsReceiving->items->every(function ($item) {
    //         return $item->quantity_ordered == ($item->quantity_received + $item->balance_receivable);
    //     });

    //     // Handle vendor bills
    //     $goodsReceiving->vendor_bills()->delete(); // Remove existing vendor bills
    //     if (isset($data['vendor_bills']) && is_array($data['vendor_bills'])) {
    //         foreach ($data['vendor_bills'] as $vendorBill) {
    //             $goodsReceiving->vendor_bills()->create([
    //                 'item_index' => $vendorBill['item_index'],
    //                 'bill_no' => $vendorBill['bill_no'],
    //                 'bill_date' => $vendorBill['bill_date'] ?? null,
    //                 'amount' => $vendorBill['amount'] ?? 0,
    //             ]);
    //         }
    //     }

    //     return $goodsReceiving;
    // }

    public function updateGoodsReceiving(GoodsReceiving $goodsReceiving, array $data)
    {
        $data['invoice_id'] = $data['invoice'];
        $data['party_id']   = $data['supplier'];
        $data['company_id'] = $data['company'];

        // Update Goods Receiving record
        $goodsReceiving->update($data);

        // Delete old stocks & items
        $goodsReceiving->stocks()->delete();
        $goodsReceiving->items()->delete();

        $items = $data['items'] ?? [];

        foreach ($items as $item) {
            $grn_items = $item['grn_items'] ?? [];

            foreach ($grn_items as $key => $grn_item) {
                $grn_item['product_id']           = $item['product'] ?? null;
                $grn_item['raw_material_item_id'] = $item['raw_material_item'] ?? null;
                $grn_item['code']                 = $item['code'] ?? null;
                $grn_item['description']          = $item['description'] ?? null;
                $grn_item['quantity_ordered']     = $item['quantity_ordered'] ?? null;
                $grn_item['quantity_received']    = $item['quantity_received'] ?? null;

                if ($grn_item['product_id']) {
                    $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('product_id', $grn_item['product_id'])
                        ->latest('id')
                        ->value('goods_receiving_id');
                } elseif ($grn_item['raw_material_item_id']) {
                    $grn_item['last_goods_receiving_id'] = GoodsReceivingItem::where('raw_material_item_id', $grn_item['raw_material_item_id'])
                        ->latest('id')
                        ->value('goods_receiving_id');
                }

                // Create new Goods Receiving Item
                $goodsReceiving->items()->create($grn_item);

                // Create new Stock entry
                $grn_item['quantity']   = $grn_item['balance_receivable'];
                $grn_item['total']      = $grn_item['total_amount'];
                $grn_item['company_id'] = $data['company_id'];

                $goodsReceiving->stocks()->create($grn_item);
            }
        }

        // ✅ Invoice Status Check
        $allCompleted = $goodsReceiving->items->count() > 0 &&
            $goodsReceiving->items->every(function ($item) {
                return $item->quantity_ordered <= ($item->quantity_received + $item->balance_receivable);
            });

        $status = $allCompleted ? 'COMPLETED' : 'PARTIALLY COMPLETE';

        // Update Invoice status
        Invoice::where('id', $goodsReceiving->invoice_id)->update([
            'status' => $status,
        ]);

        // Handle vendor bills
        $goodsReceiving->vendor_bills()->delete(); // Remove existing vendor bills
        if (isset($data['vendor_bills']) && is_array($data['vendor_bills'])) {
            foreach ($data['vendor_bills'] as $vendorBill) {
                $goodsReceiving->vendor_bills()->create([
                    'item_index' => $vendorBill['item_index'],
                    'bill_no'    => $vendorBill['bill_no'],
                    'bill_date'  => $vendorBill['bill_date'] ?? null,
                    'amount'     => $vendorBill['amount'] ?? 0,
                ]);
            }
        }

        return $goodsReceiving;
    }


    public function deleteGoodsReceiving(GoodsReceiving $goodsReceiving)
    {
        $goodsReceiving->stocks->each->delete();
        $goodsReceiving->items->each->delete();
        $goodsReceiving->vendor_bills()->delete();
        return $goodsReceiving->delete();
    }

    public function getGoodsReceivingById($id)
    {
        return GoodsReceiving::with(['vendor_bills', 'items', 'company', 'party', 'invoice', 'createdBy'])->findOrFail($id);
    }

    public function createGoodsReceivingCode($company_id)
    {
        $lastGoodsReceivingCode = GoodsReceiving::latest('id')->where('company_id', $company_id)->value('code');
        if ($lastGoodsReceivingCode) {
            $numberPart = (int) substr($lastGoodsReceivingCode, 3);
            $newNumberPart = $numberPart + 1;
            $newGoodsReceivingCode = 'GRN' . str_pad($newNumberPart, 5, '0', STR_PAD_LEFT);
        } else {
            $newGoodsReceivingCode = 'GRN00001';
        }
        return $newGoodsReceivingCode;
    }
}
