@php
    $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
    $whole = floor($amount); // Get the integer part
    $fraction = round(($amount - $whole) * 100); // Get the decimal part

    $amountInWords = $formatter->format($whole) . ' rupees';
    if ($fraction > 0) {
        $amountInWords .= ' and ' . $formatter->format($fraction) . ' paise';
    }
@endphp

{{ ucfirst($amountInWords) }}