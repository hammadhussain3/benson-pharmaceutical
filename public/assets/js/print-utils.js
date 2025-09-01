/**
 * Print Utilities for Streamline System
 * Provides consistent print functionality with timestamp across all documents
 */

function printWithTimestamp(containerId = 'printTimestampContainer') {
    // Add timestamp to footer before printing
    const timestampContainer = document.getElementById(containerId);
    
    // Create timestamp div if container doesn't exist
    if (!timestampContainer) {
        const newContainer = document.createElement('div');
        newContainer.id = containerId;
        newContainer.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
        document.body.appendChild(newContainer);
    }
    
    const timestampDiv = document.createElement('div');
    timestampDiv.id = 'printTimestamp';
    timestampDiv.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
    timestampDiv.innerHTML = '<strong>Printed on:</strong> ' + new Date().toLocaleString('en-GB');
    
    // Clear any existing timestamp and add new one
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    container.appendChild(timestampDiv);
    
    // Add print-specific styles for the timestamp
    const printStyle = document.createElement('style');
    printStyle.id = 'printTimestampStyle';
    printStyle.textContent = `
        @media print {
            #printTimestamp {
                visibility: visible !important;
                display: block !important;
                text-align: center !important;
                margin-top: 20px !important;
                font-size: 14px !important;
                color: #666 !important;
                page-break-inside: avoid !important;
            }
            #printTimestampContainer {
                visibility: visible !important;
                display: block !important;
            }
        }
    `;
    document.head.appendChild(printStyle);
    
    // Small delay to ensure DOM is updated before printing
    setTimeout(() => {
        // Print
        window.print();
        
        // Remove timestamp and styles after printing (with longer delay)
        setTimeout(() => {
            if (container) {
                container.innerHTML = '';
            }
            const styleElement = document.getElementById('printTimestampStyle');
            if (styleElement) {
                styleElement.remove();
            }
        }, 2000); // Increased delay to 2 seconds
    }, 100);
}

// Legacy function for backward compatibility
function printGRN() {
    printWithTimestamp('printTimestampContainer');
}
