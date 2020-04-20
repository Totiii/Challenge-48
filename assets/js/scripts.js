/* CACHER/MONTRER LES MENUS */
function ouvrirFermerMenu() {

    let taille = document.getElementById("sideNavigation").offsetWidth;

    if (taille == "0") {
        document.getElementById("sideNavigation").style.width = "250px";
        document.getElementById("divFermeMenu").style.bottom = "0px";
        document.getElementById("divFermeMenu").style.right = "250px";
    } else {
        document.getElementById("sideNavigation").style.width = "0px";
        document.getElementById("divFermeMenu").style.bottom = "9999px";
        document.getElementById("divFermeMenu").style.right = "0px";
    }

}

/* NAVIGATION VERS COUNTRY.PHP */
function goSearch() {
    var slug = document.getElementById("countrySelect").value;
    window.location.href = "./Country.php?slug=" + slug;
}

function goSearchMob() {
    var slug = document.getElementById("countrySelectMob").value;
    window.location.href = "./Country.php?slug=" + slug;
}

function numberWithSpaces(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}