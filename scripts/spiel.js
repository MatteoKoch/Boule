function savePoints() {
    var save = new XMLHttpRequest();
    save.open("POST", "save_points.php", true);
    save.send(getInputs());
}
function getInputs() {
    var data = new FormData();
    document.querySelectorAll(".aufstellung tbody td[id*='team']").forEach(item => {
        data.append(item.id, item.innerHTML);
    });
    return data;
}