window.onload = function() 
{
    document.getElementById('email').value = '';
};

function refreshPage() 
{
    window.scrollTo({
      top: 0,
      behavior: 'instant'
    });
    
    location.reload();
}