document.addEventListener("alpine:init", () => {
    Alpine.data("fieldSelect", (obj) => ({
        value: obj.value,
        fieldIds: [],       // Array met geselecteerde field ids
        selectedFields: [],
        search: '',         // Zoekstring
        searchResult: [],   // Zoek resultaten
        init() {
            this.searchFields()

            this.$watch("search", (e => {
                this.searchFields()
            }))
            this.$watch("fieldIds", (e => {
                this.getSelectedFields()
                this.value = this.fieldIds.join(',')
            }))

            // console.log(this.value)
            // this.fieldIds = this.value.split(',')
        },
        async getSelectedFields() {
            var data = await fetch('/target-group-api/crm-field/selected?' + new URLSearchParams({
                ids: this.fieldIds,
            }).toString())
                .then(res => res.json())
                .then(
                    function (data) {
                        return data
                    }
                )

            this.selectedFields = data
        },
        async searchFields() {
            this.searchResult = []

            console.log(this.search)
            if (this.search) {
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
        removeField(index) {
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
                function (field) {
                    return $this.fieldIds.indexOf(field.id) < 0
                }
            )
        }
    }));
});
