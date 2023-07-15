function searchBySecond(){

    var filtre, tableau, ligne, cellule, i, texte

    filtre = document.getElementById("mySearch").value.toUpperCase();
    tableau = document.getElementById("table");
    ligne = tableau.getElementsByTagName("tr");

    for(i=0; i<ligne.length; i++){
        cellule = ligne[i].getElementsByTagName("td")[1];
        if(cellule){
            texte = cellule.innerText;
            if(texte.toUpperCase().indexOf(filtre) > -1){
                ligne[i].style.display = "";
            }else{
                ligne[i].style.display = "none";
            }
        }
    }
}

function searchByThird(){

    var filtre, tableau, ligne, cellule, i, texte

    filtre = document.getElementById("mySearch").value.toUpperCase();
    tableau = document.getElementById("table");
    ligne = tableau.getElementsByTagName("tr");

    for(i=0; i<ligne.length; i++){
        cellule = ligne[i].getElementsByTagName("td")[2];
        if(cellule){
            texte = cellule.innerText;
            if(texte.toUpperCase().indexOf(filtre) > -1){
                ligne[i].style.display = "";
            }else{
                ligne[i].style.display = "none";
            }
        }
    }
}