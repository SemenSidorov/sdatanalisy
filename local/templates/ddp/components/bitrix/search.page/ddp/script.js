$(document).ready(function(){
    $(document).find('.search-result__item').each(function() {
        let $this = $(this);
        let $elements = $this.find('.search-result__item-element');
        let $count = 2; // количество показанных элементов
        if ($elements.length > $count) {
            $this.find('.search-result__item-btn').show();
            $elements.slice($count).hide();
            console.log($elements.slice($count));
        }
    });
    $(document)
        .on('click', '.search-result__item-btn', function() {
            $(this).hide();
            $(this).parents('.search-result__item').find('.search-result__item-element').show();
        })
})