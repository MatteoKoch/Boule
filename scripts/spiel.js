function savePoints(href=false) {
    var save = new XMLHttpRequest();
    save.open("POST", "save_points.php", true);
    save.onload = () => {
        if(href) {
            window.location = "rangliste";
        }
    }
    save.send(getInputs());
}
function getInputs() {
    var data = new FormData();
    document.querySelectorAll(".aufstellung tbody td[id*='team']").forEach(item => {
        data.append(item.id, item.innerHTML);
    });
    return data;
}