$(document).ready(function() {
    $(document)
        .on('click', '.js-add-favorites', function (e) {
            e.preventDefault();
            if ($(this).is('.clinics-detail__add-favourites--active')) {
               header_favorite.addItem($(this).data('id'));
            } else {
                 header_favorite.delItem($(this).data('id'));
            }
        })
        .on('click', '.header__favorite-dropdown-remove', function (e) {
            e.preventDefault();
            header_favorite.delItem($(this).data('id'));
        });
})

var header_favorite = new Vue({
    el: '#header_favorite',
    data: {
        'items': [],
    },
    watch: {

        /* при изменении элементов меняем состояние кнопки "добавить в избранное" и актуализируем счетчик элементов */
        items: function (itemsNew, itemsOld) {
            this.changeItems(itemsNew, itemsOld);
        }
    },
    methods: {

        changeItems: function (itemsNew, itemsOld) {
            $(document).find('.js-add-favorites').each(function () {
                if ($(this).is('.clinics-detail__add-favourites--active')) {
                    $(this)
                        .toggleClass('clinics-detail__add-favourites--active')
                        .find('.clinics-detail__add-favourites__text').toggle();
                }
            });
            itemsNew.forEach(function (item) {
                $(document).find('.js-add-favorites[data-id=' + item['id'] + ']').each(function () {
                    $(this)
                        .toggleClass('clinics-detail__add-favourites--active')
                        .find('.clinics-detail__add-favourites__text').toggle();
                });
            })
        },

        addItem: function (id = 0) {
            axios.get('/local/scripts/ajax.php', {
                params: {
                    ob: 'favorites',
                    fun: 'add',
                    id: id,
                }
            })
                .then(function (response) {
                    if (response.data.succes) {
                        header_favorite.items.push(response.data.item);
                    }
                });
        },

        delItem: function (id = 0) {
            axios.get('/local/scripts/ajax.php', {
                params: {
                    ob: 'favorites',
                    fun: 'del',
                    id: id,
                }
            })
                .then(function (response) {
                    if (response.data.succes) {
                        header_favorite.items.forEach(function (item, i) {
                            if (item['id'] == id) {
                                header_favorite.items.splice(i, 1);
                            }
                        });
                    }
                });
        },
    }
})

Vue.component('favorite-item', {
    props: ['item'],
    template: `
        <div class="header__favorite-dropdown-item">
            <a class="header__favorite-dropdown-link" v-bind:href="item.link">{{ item.adress }}</a>
            <a class="header__favorite-dropdown-remove" v-bind:data-id="item.id" href="#"></a>
        </div>
    `
})
Vue.component('favorite-items-count', {
    props: ['count'],
    template: `
        <div class="header__favorite-num" v-if="count > 0">{{ count }}</div>
    `
})