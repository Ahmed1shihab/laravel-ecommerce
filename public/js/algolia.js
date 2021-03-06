(function () {
    var client = algoliasearch(
        "51LOD6NL6O",
        "7bec637ff57a64e4a6c9109bc7baf0f2"
    );
    var index = client.initIndex("products");
    let enterPressed = false;
    //initialize autocomplete on search input (ID selector must match)
    autocomplete(
        "#aa-search-input",
        { hint: false },
        {
            source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
            //value to be displayed in input control after user's suggestion selection
            displayKey: "name",
            //hash of templates used when rendering dataset
            templates: {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function (suggestion) {
                    const markup = `
                        <div class="algolia-result">
                            <span>
                                <img src="${window.location.origin}/images/${
                        suggestion.image
                    }" alt="img" class="algolia-thumb">
                                ${suggestion._highlightResult.name.value}
                            </span>
                            <span>$${(suggestion.price / 100).toFixed(2)}</span>
                        </div>
                        <div class="algolia-details">
                            <span>${
                                suggestion._highlightResult.details.value
                            }</span>
                        </div>
                    `;

                    return markup;
                },
                empty: function (result) {
                    return (
                        '<div class="p-3">Sorry, we did not find any results for "' +
                        result.query +
                        '"</div>'
                    );
                },
            },
        }
    )
        .on("autocomplete:selected", function (event, suggestion, dataset) {
            window.location.href =
                window.location.origin + "/shop/" + suggestion.slug;
            enterPressed = true;
        })
        .on("keyup", function (event) {
            if (event.keyCode == 13 && !enterPressed) {
                window.location.href =
                    window.location.origin +
                    "/search?q=" +
                    document.getElementById("aa-search-input").value;
            }
        });
})();
