/**
 * SENIOR-CARE: Live Age Calculation
 * Works for both Single Registration and Multiple Edit Modals
 */
function calculateAge(rowId = '') {
    // If an ID is passed (Edit Modal), attach it. Otherwise, use default (Registration).
    const inputId = rowId ? 'bdayInput_' + rowId : 'bdayInput';
    const displayId = rowId ? 'ageDisplay_' + rowId : 'ageDisplay';
    
    const bdayInput = document.getElementById(inputId).value;
    if(!bdayInput) return;
    
    const bday = new Date(bdayInput);
    const today = new Date();
    
    let age = today.getFullYear() - bday.getFullYear();
    const m = today.getMonth() - bday.getMonth();
    
    // Adjust age if birthday hasn't happened yet this year
    if (m < 0 || (m === 0 && today.getDate() < bday.getDate())) {
        age--;
    }
    
    // Update the display text
    const displayElement = document.getElementById(displayId);
    if (displayElement) {
        displayElement.innerText = "Derived Age: " + (isNaN(age) ? "--" : age + " Years Old");
    }
}