window.onload = () => {
    // For displaying the only one window
    const divs           = document.querySelectorAll('.show-film');
    const inputSub       = document.querySelectorAll('.sub_client');
    const subTitle       = document.querySelector('.sub-title:last-child');
    const defaultText    = subTitle.textContent;
    const selectOption   = createSelectOption();
    
    const buttonMore        = document.createElement('button');
    buttonMore.className    = 'more';
    const buttonValid       = document.createElement('button');
    buttonValid.textContent = "Envoyer";
    buttonValid.className   = 'send';

    let clickDiv = 0;
    divs.forEach((element, iter) => {
        element.addEventListener('click', () => {
            clickDiv++;
            for (let i = 0; i < divs.length; i++) {
                if (clickDiv % 2 == 1) {
                    divs[i].style.display = 'none';
                    subTitle.textContent = 'Séléction en cours...'
                    element.style.display = 'block';
                } else {
                    divs[i].style.display = 'block';
                    subTitle.textContent = defaultText;
                }
            }

            //Display button
            if (clickDiv % 2 == 1) {
                element.appendChild(selectedDiv(buttonMore, inputSub[iter]));
                buttonMore.addEventListener('click', () => {
                    clickDiv = 0;
                    if (inputSub[iter].value != "unknown") {
                        window.location.href = `../../pages/admin_access_pages/modify_subscription.php?id_client=${element.childNodes[17].value}`;
                    } else {
                        clickDiv = 0;
                        divs[iter].childNodes[3].childNodes[2].textContent = "";
                        divs[iter].childNodes[3].childNodes[2].appendChild(selectOption);
                        selectOption.addEventListener('change', () => {
                            buttonMore.style.display = "none";
                            clickDiv = 0;
                            element.appendChild(buttonValid);
                            const valueOption = selectOption[selectOption.selectedIndex].value;
                            buttonValid.addEventListener("click", () => {
                                window.location.href = `../../pages/admin_access_pages/search_member.php?id_client=${element.childNodes[17].value}&select_sub=${valueOption}&submited=1`;
                            });
                        });
                        
                    }
                })
            } else {
                element.removeChild(selectedDiv(buttonMore, inputSub[iter]));
                element.removeChild(buttonValid);
                buttonMore.style.display = "inline";
            }

            if (clickDiv >= 4) {
                clickDiv = 0;
            }
        });
    });
};

const selectedDiv = (buttonMore, inputSub) => {
    if (inputSub.value == "unknown") {
        buttonMore.textContent = "Ajouter un abonnement";
    } else {
        buttonMore.textContent = 'Voir plus';
    }
    return buttonMore;
}

const createSelectOption = () => {
    //Change unknow span by select element
    const selectOption  = document.createElement('select');

    const options_sub   = new Array("", "VIP", "GOLD", "Classic", "Pass Day");
    const tabOptionsSub = new Array();
    for (let i = 0; i < options_sub.length; i++) {
        const options = document.createElement('option');
        options.value = options_sub[i];
        options.textContent = options_sub[i];
        tabOptionsSub.push(options);
        selectOption.appendChild(tabOptionsSub[i]);
    }
    tabOptionsSub[0].textContent = "Choisissez un abonnement";
    return selectOption;
}

const submitBtn = (btnValid, optionCheck) => {

}