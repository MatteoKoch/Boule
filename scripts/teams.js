var form = document.querySelector(".form-wrapper");
var team = document.querySelector(".team-block").cloneNode(true);
var globalIndex = 0;
function addTeam() {
    //var newTeam = team.cloneNode((true));
    //form.appendChild(newTeam);
    //addMemberInputs(newTeam.querySelector(".team-members"), ++globalIndex);
    var save = new XMLHttpRequest();
    save.open("POST", "save_teams.php", true);
    save.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    save.onload = () => {
        showTeams();
        resetMemberInputs(document.querySelector(".team-members"), 0);
    }
    save.send(getInputs());
}
function showTeams() {
    var show = new XMLHttpRequest();
    show.open("GET", "zeige-teams.php", true);
    show.onload = () => {
        document.querySelector("#teams").innerHTML = show.responseText;
    }
    show.send();
}
function getInputs() {
    let params = "";
    document.querySelectorAll("input[type='text']").forEach(item => params += `${item.name}=${item.value}&`);
    return params.slice(0, -1);
}
function addMemberInputs(elem, index) {
    let localIndex = 0;

    var wrapper = document.createElement("div");
    wrapper.className = "team-wrapper";

    var member1 = document.createElement("input");
    member1.type = "text";
    member1.name = `member[${index}][]`;
    member1.placeholder = `Mitglied ${++localIndex}`;

    var member2 = document.createElement("input");
    member2.type = "text";
    member2.name = `member[${index}][]`;
    member2.placeholder = `Mitglied ${++localIndex}`;

    var button = document.createElement("button");
    button.type = "button";
    button.innerHTML = "+ Mitglied hinzuf&uuml;gen";
    button.onclick = () => {
        var member = document.createElement("input");
        member.type = "text";
        member.name = `member[${index}][]`;
        member.placeholder = `Mitglied ${++localIndex}`;
        wrapper.appendChild(member);
    }

    wrapper.appendChild(member1);
    wrapper.appendChild(member2);

    elem.appendChild(wrapper);
    elem.appendChild(button);
}
function resetMemberInputs(elem, index) {
    elem.innerHTML = "";

    document.querySelector("input[name='team[]']").value = "";

    let localIndex = 0;

    var wrapper = document.createElement("div");
    wrapper.className = "team-wrapper";

    var member1 = document.createElement("input");
    member1.type = "text";
    member1.name = `member[${index}][]`;
    member1.placeholder = `Mitglied ${++localIndex}`;

    var member2 = document.createElement("input");
    member2.type = "text";
    member2.name = `member[${index}][]`;
    member2.placeholder = `Mitglied ${++localIndex}`;

    var button = document.createElement("button");
    button.type = "button";
    button.innerHTML = "+ Mitglied hinzuf&uuml;gen";
    button.onclick = () => {
        var member = document.createElement("input");
        member.type = "text";
        member.name = `member[${index}][]`;
        member.placeholder = `Mitglied ${++localIndex}`;
        wrapper.appendChild(member);
    }

    wrapper.appendChild(member1);
    wrapper.appendChild(member2);

    elem.appendChild(wrapper);
    elem.appendChild(button);
}
addMemberInputs(document.querySelector(".team-block .team-members"), globalIndex);