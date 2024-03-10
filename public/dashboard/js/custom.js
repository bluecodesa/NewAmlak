function addCheckedToDive(input) {
    let cardDiv = input.parentElement.parentElement;
    if(input.checked){
        if(!cardDiv.classList.contains('checkedd'))
        cardDiv.classList.add('checkedd');
    }else{
        if(cardDiv.classList.contains('checkedd'))
        cardDiv.classList.remove('checkedd');
    }

}
function selectAllForDelete() {
    let inputs = document.querySelectorAll('input#flexCheckDefault');
    let first_state = inputs[0].checked;
    if(!first_state)
    document.querySelector(".select-all-content").innerText = 'الغاء تحديد الكل';

    else
    document.querySelector(".select-all-content").innerText = ' تحديد الكل';


    for(let i=0 ; i<inputs.length ;i++){
        inputs[i].checked=!first_state;
        addCheckedToDive(inputs[i]);
    }
}




