window.onload = () => {
    const rows        = document.querySelectorAll('.row-selected');
    const divChild    = document.querySelector('.child');
    const form_modify = document.querySelector('#form_modify');
    const return_btn  = document.querySelector('#return_btn');
    const form_del    = document.querySelector('#form_del');
    const inputHiddenMod = document.createElement('input');
    inputHiddenMod.type  = 'hidden';
    inputHiddenMod.name  = 'modify_sub';
    
    const inputHiddenDel = document.createElement('input');
    inputHiddenDel.type  = 'hidden';
    inputHiddenDel.name  = 'del_sub';

    const userContent = new Array();
    let   clickRow    = 0;

    rows.forEach(rowElement => {
        rowElement.addEventListener('click', () => {
            clickRow++;
            for (let i = 0; i < rows.length; i++) {
                if (clickRow % 2 == 1) {
                    rows[i].style.display    = 'none';
                    rowElement.style.display = 'table-row';
                } else {
                    rows[i].style.display    = 'table-row';
                }
            }
            if (clickRow % 2 == 1) {
                //Display div
                divChild.style.display = 'block';
                form_modify.appendChild(inputHiddenMod);
                form_del.appendChild(inputHiddenDel);
                //Data to store
                const userContent = rowContent(rowElement);
                pElementsContent(userContent[1], userContent[2], userContent[4], userContent[6]);
                inputHiddenMod.value = userContent[0];
                inputHiddenDel.value = userContent[0];
            } else {
                divChild.style.display = 'none';
            }
        })
    });
};

const rowContent = rowElement => {
    const userContent = new Array();
    for (let i = 0; i < rowElement.cells.length; i++) {
        userContent.push(rowElement.cells[i].textContent);
    }
    return userContent;
}

const pElementsContent = (lastname, firstname, subs, expSubs) => {
    const pElement = document.querySelectorAll('.child p');
    pElement[0].innerHTML = `<strong>Nom: </strong> ${lastname}`;
    pElement[1].innerHTML = `<strong>Prénom: </strong>${firstname}`;
    pElement[2].innerHTML = `<strong>Abonnement actuel: </strong>${subs}`;
    pElement[3].innerHTML = `<strong>Durée d'abonnement: </strong>${expSubs}`;
}

const viewAllSubs = button => {
    window.location.href = './modify_subscription.php';
}

const confirmDelete = () => {
    return confirm('Are you sure you want to delete this subscription ?');
}