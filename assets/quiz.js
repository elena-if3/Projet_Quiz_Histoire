let elements = document.getElementsByClassName("option");

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener("click", responseFeedback);
}

function responseFeedback(event) {

    const card = event.currentTarget;

    if (card.dataset.type === "correct") {
        let correct = "<div class='card' style='width: 18rem; background-color: green;'>";
        card.innerHTML = correct;
    }
    else {
        let erroneous = "<div class='card' style='width: 18rem; background-color: red;'>";
        card.innerHTML = erroneous;
    }
}