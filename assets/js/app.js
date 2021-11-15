// let header = document.querySelector(".header");
// let nav = document.querySelector(".navbar");

// let waypoint = new Waypoint({
//     element: document.getElementById('share'),
//     handler: function(direction) {
//         if (direction == 'down'){

//             nav.classList.add("animate__slideInUp")
//             nav.classList.add("d-none")
//             nav.classList.remove("d-block")
            
//         }else{
//             nav.classList.remove("d-none")
//             nav.classList.remove("animate__slideInUp")
//             nav.classList.add("d-block")
//         }
    
//     },
   
// })

function toDark() {
    $("html").attr("theme","dark");
    localStorage.setItem("theme","dark");
}

function toLight() {
    $("html").attr("theme","light");
    localStorage.setItem("theme","light");
}


$(".modeBtn").click(function () {

    const color = localStorage.getItem("theme");

    if (color === "dark") {
        toLight();
    } else {
        toDark();
    }

});

const color = localStorage.getItem("theme");

if (color === "dark") {
    toDark();
} else {
    toLight();
}
