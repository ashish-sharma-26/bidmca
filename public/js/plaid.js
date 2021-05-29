function generatePlaidLinkToken() {
    disableElement('#authBtn', true);
    api.generatePlaidLinkToken().then(res => {
        const plaidObject = this.plaidObject(res.data.response.link_token);
        plaidObject.open();
    }).catch(error => {
        disableElement('#authBtn', false);
        showNotification(error.response.data.message, 'error');
    });
}

function generatePlaidLinkTokenGuest() {
    disableElement('#authBtn', true);
    const appId = $('#unique_id').val();
    api.generatePlaidLinkTokenGuest(appId).then(res => {
        const plaidObject = this.plaidObject(res.data.response.link_token);
        plaidObject.open();
    }).catch(error => {
        disableElement('#authBtn', false);
        showNotification(error.response.data.message, 'error');
    });
}

function plaidObject(token) {
    return Plaid.create({
        token: token,
        onSuccess: (public_token, metadata) => {
            handlePlaidSuccess(public_token, metadata);
        },
        onLoad: () => {},
        onExit: (err, metadata) => {
            handlePlaidExit();
        },
        onEvent: (eventName, metadata) => {
            if(eventName == 'HANDOFF'){
                showNotification('Successfully Authorized. Please continue','success');
            }
        },
        receivedRedirectUri: null,
    });
}

function handlePlaidSuccess(public_token, metadata) {
    const application_id = $('#unique_id').val();
    const data = {
        application_id,
        public_token,
        metadata,
    };
    $('#bank').val(metadata.institution.name);
    api.storePlaidInfo(data).then(res => {
        $('#authBtn').text('Successfully Authorized');
    }).catch(error => {
        disableElement('#authBtn', false);
        showNotification(error.response.data.message, 'error');
    });
}

function handlePlaidExit() {
    disableElement('#authBtn', false);
    showNotification('Authorization cancelled. Please try again.')
}
