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

function updateDom(data) {
    console.log(data);
    this.setAvgTerm(data);
    this.setAvgFactor(data);
    this.setBidStatus(data);
    return true;
}

function setAvgFactor(data) {
    $('#avg_factor_'+data.id).html(data.avg_factor);
    return true;
}

function setAvgTerm(data) {
    $('#avg_term_'+data.id).html(data.avg_term);
    return true;
}

function setBidStatus(data) {
    const bids = data.bids;
    if(bids.length){
        var bidHtml = ``;
        bids.map((bid) => {
            bidHtml += `<tr>
                <td>${bid.first_name} ${bid.last_name}</td>
                <td>${bid.interest_rate}</td>
                <td>${bid.duration}</td>
                <td>$${bid.amount}</td>
                <td>
                    ${bid.status == 1 ? '<label class="badge badge-success">Winning</label>' : '<label class="badge badge-danger">Lost</label>'}
                </td>
            </tr>`;
        })
        $('#bidWrap').html(bidHtml);
    }
    return true;
}
