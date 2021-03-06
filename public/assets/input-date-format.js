function dateFormat(date) {
    var date = new Date(date);
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var format = date.getFullYear() + "-" + (month) + "-" + (day);
    return format;
}