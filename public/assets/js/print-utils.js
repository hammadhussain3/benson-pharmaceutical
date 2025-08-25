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
    timestampDiv.style.cssText = 'text-align: center; margin-top: 20px; font-size: 14px; color: #666;';
    timestampDiv.innerHTML = '<strong>Printed on:</strong> ' + new Date().toLocaleString('en-GB');
    
    // Clear any existing timestamp and add new one
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    container.appendChild(timestampDiv);
    
    // Print
    window.print();
    
    // Remove timestamp after printing
    setTimeout(() => {
        container.innerHTML = '';
    }, 1000);
}

// Legacy function for backward compatibility
function printGRN() {
    printWithTimestamp('printTimestampContainer');
}
