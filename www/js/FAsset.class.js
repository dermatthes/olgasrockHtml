


function FAsset () {

}

FAsset.baseUrl = "media/event/";

FAsset.eventIconUrl = function (id) {
    return FAsset.baseUrl + id + ".jpg";
};
FAsset.eventInfoUrl = function (id) {
    return FAsset.baseUrl + id + ".html";
};
FAsset.eventImageUrl = function (id) {
    return FAsset.baseUrl + id + ".jpg";
};