$(document).ready(function(){

    getArticlesMore(document);

   $(document)
        .on('change', '.sorting__select', function () {
            var params = new URLSearchParams(location.search.slice(1));
            params.set($(this).data('param'),$(this).val());
            window.location = location.pathname + '?' + params;
			
        })
        // отработка кнопки "показать еще"
       .on('click', '.articles__pagination .search__more', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                dataType: "html",
                success: function(response) {
                    $('.articles__list').append($(response).find('.articles__list').html());
                    getArticlesMore(response);
                },
                error: function(response) { }
            });
            return false;
        });
})

// замена пагинации кнопкой "показать еще"
function getArticlesMore(doc)
{
    if ($(doc).find('.articles__pagination').text() != '') {
        if ($(doc).find('a').is('.articles__pagination .bx-pag-next a')) {
            next_url = $(doc).find('.articles__pagination .bx-pag-next a').attr('href');
            $(document).find('.articles__pagination').html('<a class="search__more" href="'+next_url+'"><span class="show">Показать еще</span></a>');
        } else {
            $(document).find('.articles__pagination').html('');
        }
    }
}