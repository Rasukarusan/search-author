// var endPoint = 'https://nameless-sands-66548.herokuapp.com/instagram'
var endPoint = 'http://localhost:9000/action.php'
var total = 0
var progress = 0

/**
 * ぶっこ抜くボタン押下時 
 */
$('#submit').click(function() {
    console.log("osita")
    initializeProgress()
    var titles = $('#titles').val().split('\n')
    console.log(titles)
    total = titles.length
    exec(titles)
    // titles.forEach(function(title) { exec([title]) })
})

function exec(titles) {
    console.log("ikimasu")
    $('#result-view-title').text('取得中...')
    $('#result-view-progress').text(`${progress}/${total}`)
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
        console.log(results)
        var resultText = ''
        results.forEach(function(result) {
            let title = result.title
            let authors = result.authors
            resultText += title + '\t' + authors + '\n'
        })
        console.log(resultText)
        $('#resultText').val(resultText);
    })
    .fail((data) => {
        console.log("ajax失敗")
    })
    .always((data) => {
        initializeProgress()
    });
}

function initializeProgress() {
    total = 0
    progress = 0
    $('#result-view-progress').text('')
    $('#result-view').empty()
}

