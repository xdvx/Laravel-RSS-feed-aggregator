"use strict"

function _specialChars(text) {
    let div = document.createElement('div');
    let textNode = document.createTextNode(text);
    div.appendChild(textNode);
    return div.innerHTML;
}

class Front {
    constructor() {
        this.$tbody = $('table tbody');
        this.categories = null;

        this.postModal();
        this.infiniteScroll();
        this.handleCategories();
    }

    postModal() {
        $('#post-modal').on('show.bs.modal', function (event) {
            let $eventRaiser = $(event.relatedTarget);
            let title = $eventRaiser.data('title');
            let description = $eventRaiser.data('description');
            let link = $eventRaiser.data('link');

            let $modal = $(this);
            $modal.find('.modal-title').text(title);
            $modal.find('.modal-body').html(description);
            $modal.find('a[data-post-link]').attr('href', link);
        });
    }

    handleCategories()
    {
        let $categories = $('select#categories');

        $categories.on('change', () => {
            this.categories = $categories.val();
            this.$tbody.html('');
            this._loadContent('api/posts', () => {});

        });
    }

    _appendRow(row) {

       let rowHtml = `<tr>
        <td><a target="_blank" href="${row.feed.provider_url}"><span class="badge badge-pill badge-danger">${_specialChars(row.feed.title)}</span></a></td>
        <td><a data-toggle="modal" data-target="#post-modal" href="#" data-link="${row.url}" data-title="${_specialChars(row.title)}" data-description="${_specialChars(row.text)}">${_specialChars(row.title)}</a></td>
        </tr>`;

       this.$tbody.append(rowHtml);

    }

    _loadContent(endPoint, callback) {
        $.post(endPoint, {categories: this.categories}, (response) => {
            let nextPageEndPoint = null;

            if (response.next_page_url) {
                nextPageEndPoint = response.next_page_url;
            }

            if (response.data) {
                for (let row of response.data) {
                    this._appendRow(row);
                }
            }

            callback.apply(this, [nextPageEndPoint]);
        });
    }

    infiniteScroll() {
        require('jquery-on-infinite-scroll');

        let nextPageEndPoint = 'api/posts?page=2';
        let locked = false;

        $.onInfiniteScroll(() => {
            // Fetch & append some content
            if (! locked) {
                locked = true;

                this._loadContent(nextPageEndPoint, (nextPage) => {
                    if (nextPage) {
                        locked = false;
                        nextPageEndPoint = nextPage;
                    }
                });

            }
        });

    }

}



module.exports = new Front();