// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDGUGBag1OtEp5wu18JT0mQXk7qTPWPsOk",
    authDomain: "bidmca.firebaseapp.com",
    databaseURL: "https://bidmca-default-rtdb.firebaseio.com",
    projectId: "bidmca",
    storageBucket: "bidmca.appspot.com",
    messagingSenderId: "983661160149",
    appId: "1:983661160149:web:d73f99b6ad5066bdea645c",
    measurementId: "G-4GVBKRVN9R"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const database = firebase.database();
let ignoreRequest = true;

// DB REF
const ref = database.ref('applications');

// INITIAL VALUE FALSE
ref.once('value', function (snapshot) {
   ignoreRequest = false;
});

// WHEN A RECORD ADDED TO RTDB
ref.on('child_added', function (snapshot) {
   if(!ignoreRequest){
       const data = snapshot.val();
       this.updateDom(data);
   }
});

// WHEN A RECORD UPDATED TO RTDB
ref.on('child_changed', function (snapshot) {
    if(!ignoreRequest){
        const data = snapshot.val();
        this.updateDom(data);
    }
});


function showRTNotification() {
    new Notification('bidmca!', {
        body: 'Your bidding status updated!',
        icon: 'http://13.212.91.216/images/logo1.png',
    });
    return true;
}

function updateDom(data) {
    this.setAvgTerm(data);
    this.setAvgFactor(data);
    this.setBidStatus(data);
    return true;
}

function setAvgFactor(data) {
    $('#avg_factor_wrap_'+data.id).show();
    $('#avg_factor_'+data.id).html(data.avg_factor);
    return true;
}

function setAvgTerm(data) {
    $('#avg_term_wrap_'+data.id).show();
    $('#avg_term_'+data.id).html(data.avg_term);
    return true;
}

function setBidStatus(data) {
    const bids = data.bids;
    const latest_bid_by = data.latest_bid_by;
    if(bids.length){
        bids.map((bid) => {
            if($('#bid_'+bid.id).length){
                $('#bid_'+bid.id+' label').remove();
                if(bid.status == 1){
                    $('#bid_'+bid.id).append(`<label class="badge badge-success">Winning</label>`);
                }else if(bid.status == 2){
                    $('#bid_'+bid.id).append(`<label class="badge badge-danger">Losing</label>`);
                }
            }
            if($('#user_'+bid.user_id).length){
                if(bid.user_id !== latest_bid_by){
                    this.showRTNotification();
                }
            }
        })
    }
    return true;
}
