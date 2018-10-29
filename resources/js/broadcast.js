
window.Echo.channel('messages-chanel')
    .listen('MessageSended', e => {
        //console.log('Message has been sent');
        console.log('Message: ' + e.message);
        console.log('For Advert: /"' + e.advert.title + '/"');
    })


//
// let app = new Vue({
//     el: '#app',
//     data: {
//         viewers: [],
//         count: 0
//     },
//     mounted(){
//         this.listen();
//         console.log(('advert.' + {{$advert->id}}));
//     },
//     methods: {
//         listen() {
//             Echo.join('advert.' + '{{$advert->id}}')
//                 .here((users) => {
//                     this.count = users.length;
//                 })
//                 .joining((users) => {
//                     this.count++;
//                 })
//                 .leaving((users) => {
//                     this.count--;
//                 })
//                 // .listen()
//         }
//     }
// })