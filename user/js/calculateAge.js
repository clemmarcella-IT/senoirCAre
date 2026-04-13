/**
 * SENIOR-CARE: Live Age Calculation
 */
function calculateAge() {
    const bdayInput = document.getElementById('bdayInput').value;
    if(!bdayInput) return;
    
    const bday = new Date(bdayInput);
    const today = new Date();
    
    let age = today.getFullYear() - bday.getFullYear();
    const m = today.getMonth() - bday.getMonth();
    
    // Adjust age if birthday hasn't happened yet this year
    if (m < 0 || (m === 0 && today.getDate() < bday.getDate())) {
        age--;
    }
    
    // Update the display text in the form
    document.getElementById('ageDisplay').innerText = "Derived Age: " + (isNaN(age) ? "--" : age + " Years Old");
}