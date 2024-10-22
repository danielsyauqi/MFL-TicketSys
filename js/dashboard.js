

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
