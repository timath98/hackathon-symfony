document.addEventListener("DOMContentLoaded", init);

function init() {
    const inputCp = document.getElementById('utilisateur_cp');
    inputCp.addEventListener("input", changeCP);
}

function changeCP() {
    const selectVille=document.getElementById('ville-data');
    const labelVille=document.getElementById('label_ville');
    let labelVilleOrigin='Ville';
    selectVille.readOnly=true;
    if (this.value.length >=3) {
        const URL_debut = document.getElementById('utilisateur').getAttribute('data-autocomplete-url');
        const request = new XMLHttpRequest();

// Handle state changes for the request.
        request.onreadystatechange = response => {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    // Why twice ???
                    const jsonOptions = JSON.parse(JSON.parse(request.responseText));
                    while (selectVille.firstChild) {
                        selectVille.removeChild(selectVille.firstChild);
                    }
                    let compteurVille=0;
                    jsonOptions.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.nom;
                        option.text = item.nom;
                        selectVille.appendChild(option);
                        labelVille.textContent=labelVilleOrigin+' : Choisissez votre ville...';
                        selectVille.readOnly=false;
                        compteurVille++;
                    });
                    if(compteurVille===0) {
                        labelVille.textContent=labelVilleOrigin+' : Aucune ville ne correspond';
                    } else {
                        if (compteurVille===1) {
                            selectVille.focus();
                        }
                    }

                } else {
                    labelVille.textContent = labelVilleOrigin+' : Erreur de chargement';
                    selectVille.readOnly=true;
                }
            }
        };

        labelVille.textContent = labelVilleOrigin+' : Chargement des villes...';
        const URL = URL_debut.substring(0, URL_debut.length - 2) + this.value;
        request.open('GET', URL, true);
        request.send();
        selectVille.value='';
    }
}

