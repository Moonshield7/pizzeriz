//variables confettis :

const containerConfettis = document.querySelector('.containerConfettis');
const btnConfettis = document.querySelector('.btnConfettis');
const emojisConfettis =['🍕','🦄'];
btnConfettis.addEventListener('click', confettisParty)

// -------------------------------------------------------------------------------------

//functions confettis :

function confettisParty(){

    if(isTweeningConfettis()) return;

    for (let i = 0; i < 150; i++){
        const addConfettis = document.createElement('div');
        addConfettis.innerText = emojisConfettis[Math.floor(Math.random()*emojisConfettis.length)];
        containerConfettis.appendChild(addConfettis);
    }
    animateConfettis();
}

function animateConfettis() {
  
    const TLCONF = gsap.timeline();
  
    TLCONF.to(".containerConfettis div", {
      y: "random(-100,100)",
      x: "random(-100,100)",
      z: "random(0,1000)",
      rotation: "random(-90,90)",
      duration: 1,
    })
      .to(".containerConfettis div", { autoAlpha: 0, duration: 0.3 }, "-=0.2")
      .add(() => {
        containerConfettis.innerHTML = "";
      });
  }
  
  function isTweeningConfettis(){
    return gsap.isTweening('.containerConfettis div');
}