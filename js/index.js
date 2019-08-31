var endPoint = './action.php'
var total = 0
var progress = 0

/**
 * ぶっこ抜くボタン押下時 
 */
$('#submit').click(function() {
    var titles = $('#titles').val().split('\n')
    total = titles.length
    exec(titles)
})

function exec(titles) {
    $('#result-view-title').text('取得中...')
    var data ={
        'titles' : titles,
    }
    $.ajax({
        url : endPoint,
        type:'POST',
        contentType: "application/json",
        dataType: "json",
        xhrFields: {
            withCredentials: true
        },
        data:JSON.stringify(data)
    })
    .done((results) => {
        var resultText = ''
        results.forEach(function(result) {
            let title = result.title
            let authors = result.authors
            resultText += title + '\t' + authors + '\n'
        })
        $('#resultText').val(resultText);
    })
    .fail((data) => {
    })
    .always((data) => {
        $('#result-view-title').text('結果')
    });
}

