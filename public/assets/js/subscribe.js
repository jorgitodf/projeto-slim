let btn_subscribe = document.querySelector('#btn_subscribe');

btn_subscribe.onclick = function() {
    axios.post('/home/store').then((response) => {
        console.log(response.data);
    });
    
}