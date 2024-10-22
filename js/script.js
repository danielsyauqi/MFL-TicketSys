let title = document.getElementById('title');
let btn = document.getElementById('btn');
let header = document.querySelector('header');
let sub = document.getElementById('subtitle');
let hola = document.getElementById('user-hola');
let sec_title = document.getElementById('sec-title');
let btn_add = document.getElementsByClassName('btn-all');

window.addEventListener('scroll', function() {
    let value = window.scrollY;
    title.style.marginTop = value * 0.8 + 'px';
    sub.style.marginTop = value * 0.8 + 'px';
    btn.style.marginTop = value * 1.5 + 'px';
    hola.style.marginTop = value * 2 + 'px';
    
})

const headerTransition = document.querySelector('.header')
window.addEventListener('scroll', function(){

    if(window.scrollY > 500){   
        headerTransition.classList.add('header-scrolled');
    }
    else if(window.scrollY <= 500){
        headerTransition.classList.remove('header-scrolled');
    }

})

var modal = document.getElementById("modal-parent"),
btnpopup = document.getElementById("btn-popup"),
X = document.getElementById("X"),
section = document.getElementById("container"),
overall = document.querySelector("html");
var webHead = document.querySelector("header");
var webFooter = document.querySelector("footer");


var btns = document.getElementsByClassName("btn-popup");
for (var i = 0; i < btns.length; i++) {
  btns[i].onclick = function(){
    modal.style.display = "block";
    overall.style.overflow = "hidden"
    section.style.filter = "blur(5px)"
    webHead.style.filter = "blur(5px)"
    webFooter.style.filter = "blur(5px)"
  }
}




X.addEventListener("click", disappearX);
function disappearX() {
  modal.style.display = "none";
  overall.style.overflow = "scroll"
  section.style.filter = "blur(0px)"
  webHead.style.filter = "blur(0px)"
  webFooter.style.filter = "blur(0px)"
}
parent.addEventListener("click", disappearParent)
function disappearParent(e) {
  if (e.target.className == "modal-parent") {
    modal.style.display = "none";
    overall.style.overflow = "scroll"
    section.style.filter = "blur(0px)"
    webHead.style.filter = "blur(0px)"
    webFooter.style.filter = "blur(0px)"
    
  }
}

//** DELETE POPUP */

var deleteLinks = document.querySelectorAll('.btn-delete');

for (var i = 0; i < deleteLinks.length; i++) {
  deleteLinks[i].addEventListener('click', function(event) {
	  event.preventDefault();

	  var choice = window.confirm(this.getAttribute('data-confirm'));

	  if (choice) {
	    window.location.href = this.getAttribute('href');
	  }
  });
}

const confirmApprove = () => {
  if (confirm("Are you sure to approve this request?")) {
    return true;
  }

  else
  {
      window.location.assign("admin-ticket.php");
  }
}

/** search dropdown */
const select = document.getElementById("basic-select");
const menu = document.getElementById("option-select");
const dropdowns = document.querySelectorAll(".dropdown-search");
const cart = document.querySelector(".carpet");
const options = document.querySelectorAll(".options .options__item");
const selected = document.getElementById("select-title");
var active = document.querySelector(".options__item--active");
const animTime = 120;

select.addEventListener('mouseenter', function(){
  select.classList.add("selected--open");
  cart.classList.add("carpet--open");
  setTimeout(function(){
    select.classList.add("selected--delay");
  }, animTime);
})
select.addEventListener('mouseleave', function(){
  select.classList.remove("selected--open");
  cart.classList.remove("carpet--open");
  setTimeout(function(){
    select.classList.remove("selected--delay");
  }, animTime);
})
menu.addEventListener('mouseenter', function(){
  select.classList.add("selected--open");
  cart.classList.add("carpet--open");
  setTimeout(function(){
    select.classList.add("selected--delay");
  }, animTime);
})
menu.addEventListener('mouseleave', function(){
  select.classList.remove("selected--open");
  cart.classList.remove("carpet--open");
  setTimeout(function(){
    select.classList.remove("selected--delay");
  }, animTime);
})
options.forEach(option => {
  option.addEventListener("click", function(){
    selected.innerText = option.innerText;
    active.classList.remove("options__item--active");
    option.classList.add("options__item--active");
    active = document.querySelector(".options__item--active");
  });
});


/**Sales Dashboard */

//get the data from JSON 
const getData = async (url) => {
  let fetchedData = await fetch(url); 
  let data = await fetchedData.json();
  return data; 
}


const process = async ()=> {
   let data = await getData('https://shirak22.github.io/chart/data.json'); 
  //sort the objects and get the biger spend value


  let biggestNum = Math.max(...data.map( x => x.amount ));
  let total = document.querySelector('[data-total]');
  let bars_canvas = document.querySelector('[data-bar]');
  

  // render the bars
   data.forEach(element => {
          let barHeight = getBarHeight(biggestNum,element.amount).toFixed(2); 
          let aside = document.createElement('aside'); 
          aside.setAttribute('style',`--i:${barHeight}rem; --price:'$${element.amount}'`);
          let p = document.createElement('p');
          // fix all numbers dynamicly
          p.innerText = element.day;
          aside.appendChild(p); 
          bars_canvas.appendChild(aside);
         
   });

   total.textContent = `$${getTotalSpending(data)}`; 
}


process();

// convert the values to css style height - max-height: 12rem
const getBarHeight = (BiggestValue, value) => {
  return (10 * value) / BiggestValue ;
}

const getTotalSpending = (data) => {
  let total = 0; 
  data.forEach(element => {
      total += element.amount; 
  });

  return total;
}