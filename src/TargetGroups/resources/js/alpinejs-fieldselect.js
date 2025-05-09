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
                // console.log(this.fieldIds)
                this.value = this.fieldIds
            }))
        },
        async getSelectedFields() {
            const params = new URLSearchParams();
            this.fieldIds.forEach(
                function (element) {
                    params.append('fields[' + element.name + ']', element.id)
                });

            var data = await fetch('/target-group-api/crm-field/selected?' + params.toString())
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

            // console.log(this.search)
            // if (this.search) {
            var data = await fetch('/target-group-api/crm-field/search?' + new URLSearchParams({q: this.search}).toString())
                .then(res => res.json())
                .then(
                    function (data) {
                        return data
                    }
                )

            this.searchResult = data
            this.filterAddedFieldsFromSearchResults()
            // }
        },
        addField(element) {
            console.log(element)
            this.fieldIds.push(element)
            this.filterAddedFieldsFromSearchResults()
        },
        addAllFields() {
            this.searchResult.forEach(element => {
                this.addField(element)
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
                    var fields = $this.fieldIds.filter(
                        function (row) {
                            return (row.id === field.id) && (row.name === field.name)
                        }
                    );

                    return fields.length === 0
                }
            )
        }
    }));
});
