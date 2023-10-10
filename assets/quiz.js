// Get all the cards that have a class "option"
const optionCards = document.getElementsByClassName("option");

// Bind event (click) and feedback function for each of them
for (let i = 0; i < optionCards.length; i++) {
    optionCards[i].addEventListener("click", feedback);
}

// Function to provide players with feedback re. their response 
function feedback(event) {

    // get the element that is clicked on
    let card = event.currentTarget;

    // if response correct --> add "green-border" class
    if (card.dataset.type === "correct") {
        card.classList.add("green-border");
    }
    else {
        // else --> add "red-border" class
        card.classList.add("red-border");

        // transform HTML collection into array
        let arrOptionCards = Array.from(optionCards);

        // go through array
        arrOptionCards.forEach(function (option) {

            //  if correct response --> add "dotted-green-border" class
            if (option.dataset.type === "correct") {
                option.classList.add("dotted-green-border");
            }
        });
    }

    // recharger la page
    setTimeout(() => {
        window.location.href = "";
    }, 4000);

}