
const allBlockButtons = document.querySelectorAll('.profile-block-btn');
const allBlockButtonsArray = Array.from(allBlockButtons);

allBlockButtonsArray.forEach((button) => 
{
    
    const id = button.id;
    button.addEventListener('click', (e) =>
    {
        if(button.classList.contains('blocked')) 
        {
            button.classList.remove('blocked');
            button.innerHTML = 'X';
            $.ajax({
                url: '?action=unblockContent'+id,
                type: 'GET',
                data: {id: button.dataset.id},
            });

        }
        else 
        {
            button.classList.add('blocked');
            button.innerHTML = '&#10003;';
            $.ajax({
                url: '?action=blockContent'+id,
                type: 'GET',
                data: {id: button.dataset.id},
            });
        }
        
    });
    
});
