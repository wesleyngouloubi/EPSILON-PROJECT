
// Obtenir la date d'aujourd'hui
let today = new Date();

// Formater la date au format "AAAA-MM-JJ" requis par le champ de date
let formattedDate = today.toISOString().split("T")[0];

// Définir la valeur maximale pour le champ de date
document.getElementById("birthday").max = formattedDate;