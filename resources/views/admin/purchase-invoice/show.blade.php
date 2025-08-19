@extends('admin.layouts.app')

@section('content')
    @php
        // Calculate grand total for vendor export
        $grandTotal = 0;
        foreach ($invoice->items as $item) {
            $grandTotal += $item->quantity * $item->unit_price;
        }
    @endphp
    <style>
        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid #e9ecef !important;
        }

        table.table-bordered {
            border: 1px solid #e9ecef !important;
            border-collapse: collapse !important;
        }
    </style>

    <div class="page-header">
        <div class="page-title">
            <h4>{{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
            </h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('purchase-invoices.index') }}">Invoices</a></li>
                <li class="breadcrumb-item active">View
                    {{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2">
            {{-- Previous Button --}}
            @if($previous)
                <a href="{{ route('purchase-invoices.show', $previous->id) }}" class="btn btn-outline-secondary">
                    &laquo; Previous
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>&laquo; Previous</button>
            @endif

            {{-- Next Button --}}
            @if($next)
                <a href="{{ route('purchase-invoices.show', $next->id) }}" class="btn btn-outline-secondary">
                    Next &raquo;
                </a>
            @else
                <button class="btn btn-outline-secondary" disabled>Next &raquo;</button>
            @endif

            {{-- Edit Button --}}
            <a href="{{ route('purchase-invoices.edit', $invoice->id) }}" class="btn btn-light">
                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
            </a>

            {{-- Print Button --}}
            <!-- <button class="btn btn-light" onclick="window.print()" data-approved ="{{ $invoice->is_approved }}" id="print-button">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Edit">
            </button> -->
            <button class="btn btn-light" onclick="checkApprovalAndPrint(this)" data-approved="{{ $invoice->is_approved }}" id="print-button">
                <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="Print">
            </button>

            {{-- Export Button for Vendors --}}
            @if($invoice->is_approved == 1)
                <button class="btn btn-outline-primary" onclick="exportToPDF()" id="export-button" title="Export to PDF for Vendors">
                    <img src="{{ asset('assets/img/icons/download.svg') }}" alt="Export PDF" class="me-1">
                    <span>Export for Vendor</span>
                </button>
            @else
                <button class="btn btn-outline-secondary" disabled id="export-button" title="Export to PDF for Vendors - Document not approved">
                    <img src="{{ asset('assets/img/icons/download.svg') }}" alt="Export PDF" class="me-1">
                    <span>Export for Vendor</span>
                </button>
            @endif


        </div>
    </div>
    <!-- Print Button -->

    <!-- Card Component -->
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($invoice->company->logo_path ? 'images/company/' . $invoice->company->logo_path : 'images/company/logo.png') }}"
                                class="mb-2" style="height: 80px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">{{ $invoice->company->name }}</h5>
                            <p class="fs-6 mb-0">{{ $invoice->company->address }}</p>
                            <p class="fs-6 mb-0">{{ $invoice->company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end print-header">
                    <h2>{{ $invoice->type == 'purchase' ? 'Purchase Order' : ($invoice->type == 'sale' ? 'Sale Invoice' : ($invoice->type == 'quotation' ? 'Quotation' : '')) }}
                    </h2>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="width: 233px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Ref No:</strong> {{ $invoice->code }}</li>
                            <li class="list-group-item"><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</li>
                        </ul>
                    </div>
                </div>
                <div style="width: 766px;">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div style="width: 333px;">
                                        <strong>Required Date:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->required_date)->format('d M, Y') }}
                                    </div>
                                    <div class="col border-start border-end"><strong>Urgent</strong></div>
                                    <div class="col d-flex align-items-center">
                                        {!! $invoice->is_urgent == '1' ? '<i class="fa fa-check"></i>' : '' !!}
                                    </div>
                                    <div class="col border-start border-end"><strong>Ordinary</strong></div>
                                    <div class="col">{{ $invoice->is_urgent == '0' ? '*' : '' }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <strong>{{ $invoice->type == 'purchase' ? 'Supplier' : ($invoice->type == 'sale' || $invoice->type == 'quotation' ? 'Franchise' : '') }}:</strong>
                                {{ optional($invoice->party)->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Item Code</th>
                            <th rowspan="2">Description</th>
                            <th rowspan="2">Current <br>Balance</th>
                            <th rowspan="2">Min. <br>Level</th>
                            <th rowspan="2">Max. <br>Level</th>
                            <th rowspan="2">Quantity <br>Required</th>
                            <th rowspan="2">Price</th>
                            <th rowspan="2">Unit</th>
                            <th colspan="2">Last Purchase</th>
                            <th colspan="2">In-Process</th>
                            <th rowspan="2">Consumption <br>6 Month</th>
                        </tr>
                        <tr>
                            <th>Ref.</th>
                            <th>Price</th>
                            <th>PO List</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td @if ($item->description) style="white-space: inherit;" @endif>
                                    <strong class="float-start">{{ $item->title }}</strong>
                                    @if ($item->description)
                                        <br>{{ $item->description }}
                                    @endif
                                </td>
                                <td>{{ $item->balance }}</td>
                                <td>{{ $item->min_level }}</td>
                                <td>{{ $item->max_level }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit_price }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->lp_ref }}</td>
                                <td>{{ $item->lp_price }}</td>
                                <td style="white-space: inherit;">{{ $item->ip_po_list }}</td>
                                <td>{{ $item->ip_quantity }}</td>
                                <td>{{ $item->consumption_6_months }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Sub Total</strong></th>
                            <th>{{ number_format($invoice->items_cost_without_tax, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Tax Rate ({{ $invoice->invoice_tax_rate
                                    }}%):</strong></th>
                            <th>{{ number_format($invoice->total_invoice_tax, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Discount ({{ $invoice->discount_type }}):</strong>
                            </th>
                            <th>{{ number_format($invoice->discount, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right"> <strong>Total Amount:</strong></th>
                            <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
            @if ($invoice->note)
                <div style="width: 100%;">
                    <div style="margin-bottom: 15px; margin-top: 15px; font-size: 14px;">
                        <strong>Note:</strong> {{ $invoice->note }}
                    </div>
                </div>
            @endif
            <div class="signature-section" style="margin-top: 45px;">
                <div style="display: flex; justify-content: space-around; align-items: end;">
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">{{ $invoice->createdBy->name ?? null }}</span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Raised by</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Checked by Dept. Head</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">
                            {{ $invoice->approvedBy->name ?? null }}
                            ({{ $invoice->is_approved == 1 ? 'Approved' : 'Draft' }})
                        </span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Approved by: Cheif Executive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .print-header {
        margin-top: 10px !important;
    }

    @media print {
        .signature-section {
            position: fixed;
            bottom: 10px;
            left: 0;
            width: 100%;
        }

        @page {
            margin: 0;
            size: landscape;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body * {
            visibility: hidden;
        }

        .card-body,
        .card-body * {
            visibility: visible;
        }

        .card-body {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
        }

        .table-primary th {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        table.table-bordered {
            font-size: 10px !important;
        }

        .approved-target {
            background-color: #e3f2fd !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .print-header {
            margin-top: 15px !important;
        }

        /* Export button styles */
        #export-button {
            transition: all 0.3s ease;
            border-width: 2px;
        }

        #export-button:hover {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }

        #export-button:active {
            transform: translateY(0);
        }

        #export-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Responsive button layout */
        @media (max-width: 768px) {
            .page-header .d-flex {
                flex-direction: column;
                gap: 10px;
            }
            
            .page-header .d-flex .btn {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        @media print {
            #export-button {
                display: none !important;
            }
        }
    </style>
<!-- html2pdf CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


    async function exportToPDF() {
        // Check if html2pdf is available
        if (typeof html2pdf === 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Library Not Loaded!',
                text: 'PDF export library is not available. Please refresh the page and try again.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Disable export button and show loading state
        const exportButton = document.getElementById('export-button');
        const originalContent = exportButton.innerHTML;
        exportButton.disabled = true;
        exportButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Generating Vendor PDF...';

        // Show loading message
        Swal.fire({
            title: 'Generating Vendor PDF...',
            text: 'Please wait while we prepare your vendor-specific document.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create vendor-specific content
        const vendorContent = createVendorContent();
        
        // Convert images to base64 to ensure they're embedded in the PDF
        await convertImagesToBase64(vendorContent);
        
        // Debug: Check if images were converted
        const images = vendorContent.querySelectorAll('img');
        console.log('Images found:', images.length);
        images.forEach((img, index) => {
            console.log(`Image ${index + 1}:`, img.src.substring(0, 100) + '...');
        });

        // Use html2pdf library to generate PDF
        const opt = {
            margin: [10, 10, 10, 10],
            filename: 'purchase-order-{{ $invoice->code }}-{{ optional($invoice->party)->name ?? 'vendor' }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 2,
                useCORS: true,
                letterRendering: true,
                allowTaint: true,
                imageTimeout: 15000,
                logging: true,
                removeContainer: true
            },
            jsPDF: { 
                unit: 'mm', 
                format: 'a4', 
                orientation: 'portrait' 
            }
        };

        // Generate PDF
        html2pdf().set(opt).from(vendorContent).save().then(() => {
            // Re-enable button
            exportButton.disabled = false;
            exportButton.innerHTML = originalContent;
            
            Swal.fire({
                icon: 'success',
                title: 'Vendor PDF Generated!',
                text: 'Your vendor-specific purchase order has been exported successfully.',
                confirmButtonText: 'OK'
            });
        }).catch((error) => {
            // Re-enable button
            exportButton.disabled = false;
            exportButton.innerHTML = originalContent;
            
            console.error('PDF generation error:', error);
            // Offer fallback to print
            Swal.fire({
                icon: 'warning',
                title: 'PDF Export Failed!',
                text: 'Would you like to use print instead? You can then save as PDF from your browser.',
                showCancelButton: true,
                confirmButtonText: 'Use Print',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.print();
                }
            });
        });
    }

    function createVendorContent() {
        // Create a temporary container for vendor export
        const vendorContainer = document.createElement('div');
        vendorContainer.style.padding = '20px';
        vendorContainer.style.fontFamily = 'Arial, sans-serif';
        vendorContainer.style.fontSize = '12px';
        vendorContainer.style.lineHeight = '1.4';

        // Company logo and header - exactly as shown in image
        const header = `
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                <div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <img src="{{ request()->getSchemeAndHttpHost() }}/{{ $invoice->company->logo_path ? 'images/company/' . $invoice->company->logo_path : 'images/company/logo.png' }}" 
                             style="height: 60px; margin-right: 15px;" onerror="this.style.display='none';">
                        <div>
                            <div style="font-size: 16px; font-weight: bold; margin-bottom: 5px;">{{ $invoice->company->name }}</div>
                            <div style="font-size: 11px; margin-bottom: 2px;">{{ $invoice->company->address }}</div>
                            @if($invoice->company->phone)
                            <div style="font-size: 11px;">{{ $invoice->company->phone }}</div>
                            @endif
                            <div style="font-size: 11px; margin-top: 5px;">
                                <strong>Email:</strong> purchase@bensonpharmaceuticals.com
                            </div>
                            <div style="font-size: 11px;">
                                <strong>WhatsApp:</strong> 03361536294
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 20px; font-weight: bold;">Purchase Order</div>
                </div>
            </div>
        `;

        // Order details - exactly as shown in image
        const orderDetails = `
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <div style="margin-bottom: 5px;"><strong>Ref No:</strong> {{ $invoice->code }}</div>
                        <div style="margin-bottom: 5px;"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="margin-bottom: 5px;"><strong>Required Date:</strong> {{ \Carbon\Carbon::parse($invoice->required_date)->format('d M, Y') }}</div>
                        <div style="margin-bottom: 5px;"><strong>Supplier:</strong> {{ optional($invoice->party)->name ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        `;

        // Items table - exactly as shown in image with only required columns
        let itemsTable = `
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px;">
                <thead>
                    <tr style="background-color: #f5f5f5;">
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: center; font-weight: bold;">#</th>
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: left; font-weight: bold;">Item Code</th>
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: left; font-weight: bold;">Description</th>
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: center; font-weight: bold;">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: center; font-weight: bold;">Price (inclusive of tax)</th>
                        <th style="border: 1px solid #ddd; padding: 6px; text-align: center; font-weight: bold;">Total</th>
                    </tr>
                </thead>
                <tbody>
        `;

        @foreach ($invoice->items as $item)
            @php
                $itemTotal = $item->quantity * $item->unit_price;
            @endphp
            itemsTable += `
                <tr>
                    <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #ddd; padding: 6px;">{{ $item->code }}</td>
                    <td style="border: 1px solid #ddd; padding: 6px;">
                        {{ $item->title }}
                        @if ($item->description)
                            <br>{{ $item->description }}
                        @endif
                    </td>
                    <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ $item->quantity }}</td>
                    <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">{{ number_format($itemTotal, 2) }}</td>
                </tr>
            `;
        @endforeach

        itemsTable += `
                </tbody>
            </table>
        `;

        // Total section - exactly as shown in image
        const totalSection = `
            <div style="text-align: right; margin-bottom: 20px;">
                <div style="font-size: 14px; font-weight: bold;">
                    Grand Total: {{ number_format($grandTotal, 2) }}
                </div>
            </div>
        `;

        // Signature section - exactly as shown in image
        const signatureSection = `
            <div style="margin-top: 45px;">
                <div style="display: flex; justify-content: space-around; align-items: end;">
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">{{ $invoice->createdBy->name ?? 'N/A' }}</span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Raised by</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <span style="font-size: 14px; font-weight: bold;">
                            {{ $invoice->approvedBy->name ?? 'N/A' }}
                            @if($invoice->is_approved == 1)
                                (Approved)
                            @else
                                (Draft)
                            @endif
                        </span>
                        <hr style="width: 100%; margin: 5px 0px;">
                        <span style="font-size: 14px;">Approved by: Chief Executive</span>
                    </div>
                    <div style="width: 266px; text-align: center;">
                        <img src="{{ asset('images/company/stamp.jpeg') }}"
                    class="mb-2" style="height: 80px">
                    </div>
                </div>
            </div>
        `;

        // Combine all sections
        vendorContainer.innerHTML = header + orderDetails + itemsTable + totalSection + signatureSection;

        return vendorContainer;
    }

    // Function to convert images to base64 for PDF generation
    function convertImagesToBase64(container) {
        return new Promise((resolve) => {
            const images = container.querySelectorAll('img');
            if (images.length === 0) {
                resolve();
                return;
            }

            let convertedCount = 0;
            const totalImages = images.length;

            images.forEach((img) => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const newImg = new Image();
                
                newImg.crossOrigin = 'anonymous';
                newImg.onload = () => {
                    try {
                        canvas.width = newImg.width;
                        canvas.height = newImg.height;
                        ctx.drawImage(newImg, 0, 0);
                        
                        // Convert to base64
                        const dataURL = canvas.toDataURL('image/jpeg', 0.8);
                        img.src = dataURL;
                        
                        convertedCount++;
                        if (convertedCount === totalImages) {
                            resolve();
                        }
                    } catch (error) {
                        console.error('Error converting image to base64:', error);
                        convertedCount++;
                        if (convertedCount === totalImages) {
                            resolve();
                        }
                    }
                };
                
                newImg.onerror = () => {
                    console.error('Error loading image:', img.src);
                    convertedCount++;
                    if (convertedCount === totalImages) {
                        resolve();
                    }
                };
                
                newImg.src = img.src;
            });
        });
    }


</script>
