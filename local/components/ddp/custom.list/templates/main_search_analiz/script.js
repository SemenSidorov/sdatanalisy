
var main_search_analyz = new Vue({
    el: '#main_search_analyz',
    data: {
        question: '',
        items: [],
    },
    watch: {
        question: function (newQuestion, oldQuestion) {
            this.debouncedGetAnswer();
        }
    },
    created: function () {
        this.debouncedGetAnswer = _.debounce(this.getAnswer, 1000)
    },
    methods: {
        getAnswer: function () {
            let vm = this
            if (vm.question.length < 3) {
                return;
            }
            axios.get('/local/scripts/ajax.php', {
                params: {
                    ob: 'analyz',
                    fun: 'search',
                    text: vm.question,
                }
            })
                .then(function (response) {
                    if (response.data.succes) {
                        vm.items = response.data.items;
                    }
                })
        }
    }
})

Vue.component('main-search-analyz-item', {
    props: ['item'],
    template: `
        <div class="header__favorite-dropdown-item">
            <a class="header__favorite-dropdown-link" v-bind:href="item.link">{{ item.name }}</a>
        </div>
    `
})