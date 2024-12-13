const domain = 'meet.jit.si';
const options = {
    roomName: 'JitsiMeetAPIExample',
    //width: 1920,
    //height: 1080,
    parentNode: document.querySelector('#meet'),
    lang: 'en',
    // userInfo: {
    //     email: 'email@jitsiexamplemail.com',
    //     displayName: 'John Doe'
    // }
};
const api = new JitsiMeetExternalAPI(domain, options);