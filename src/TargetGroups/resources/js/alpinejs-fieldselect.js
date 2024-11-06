document.addEventListener("alpine:init", () => {
    Alpine.data("fieldSelect", (obj) => ({
        value: obj.value,
        fieldIds: [],    // Array met geselecteerde product ids
        selectedFields: [],
        search: '',         // Zoekstring
        searchResult: [],   // Zoek resultaten
        init() {
            this.$watch("search", (e => {
                this.searchFields()
            }))
            this.$watch("fieldIds", (e => {
                this.getSelectedFields()
                this.value = this.fieldIds.join(',')
            }))

            this.fieldIds = this.value.split(',')
        },
        async getSelectedFields() {
            var data = await fetch('/target-groupApi/crm-field/selected?' + new URLSearchParams({
                ids: this.fieldIds,
            }).toString())
                .then(res => res.json())
                .then(
                    function (data) {
                        return data
                    }
                )

            this.selectedProducts = data
        },
        async searchFields() {
            this.searchResult = []
            if (this.search.length > 2) {
                var data = await fetch('/target-group-api/crm-field/search?' + new URLSearchParams({
                    q: this.search,
                }).toString())
                    .then(res => res.json())
                    .then(
                        function (data) {
                            return data
                        }
                    )

                this.searchResult = data
                this.filterAddedFieldsFromSearchResults()
            }
        },
        addField(id) {
            this.fieldIds.push(id)
            this.filterAddedFieldsFromSearchResults()
        },
        addAllFields() {
            this.searchResult.forEach(element => {
                this.addField(element.id)
            })
        },
        removeProduct(index) {
            this.fieldIds.splice(index, 1)
            this.searchFields()
        },
        removeAll() {
            this.fieldIds = []
            this.searchFields()
        },
        filterAddedFieldsFromSearchResults() {
            var $this = this

            this.searchResult = this.searchResult.filter(
                function (product) {
                    return $this.fieldIds.indexOf(product.id) < 0
                }
            )
        }
    }));
});
