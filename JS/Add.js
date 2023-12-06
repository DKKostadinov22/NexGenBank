document.getElementById('paymentForm').addEventListener('input', function() 
{
var cardNumber = document.getElementById('cardNumber').value;
var expirationDate = document.getElementById('expirationDate').value;
var cvv = document.getElementById('cvv').value;
var submitButton = document.getElementById('submitButton');

// Check if the card number is 16 digits
var isCardNumberValid = cardNumber.length === 16;

// Check if the expiration date is in MM/YY format
var expirationDatePattern = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
var isExpirationDateValid = expirationDate.match(expirationDatePattern);

// Check if the CVV is 3 digits
var isCVVValid = cvv.length === 3;

// Enable/disable the submit button based on conditions
if (isCardNumberValid && isExpirationDateValid && isCVVValid) 
{
    submitButton.removeAttribute('disabled');
} else 
{
    submitButton.setAttribute('disabled', 'disabled');
}
});