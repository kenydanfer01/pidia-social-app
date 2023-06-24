
let Collection = function () {
    let confirmRemove;

    let handleEntity = function ($collectionHolder) {
        let $addLink = $(`
            <a href="#" class="btn btn-light-success btn-sm">
                <i class="fa fa-plus"></i>Agregar
            </a>
        `);
        let collectionChild = $collectionHolder.data('widget-item')
        let $newLink = $(collectionChild).append($addLink);
        initDataForm($collectionHolder, $addLink, $newLink, collectionChild);
    };

    let initDataForm = function($collectionHolder, $addLink, $newLink, collectionChild){
        $collectionHolder.find('li').each(function() {
            addBlockFormDeleteLink($(this));
        });
        $collectionHolder.append($newLink);
        $collectionHolder.data('index', $collectionHolder.find('li').length);
        $addLink.on('click', function(e) {
            e.preventDefault();
            addBlockForm($collectionHolder, $newLink, collectionChild);
        });
    };

    let addBlockForm = function($collectionHolder, $newLink, collectionChild) {
        let prototype = $collectionHolder.data('prototype');
        let index = $collectionHolder.data('index');
        let newForm;
        if($collectionHolder.data('prototype-name')){
            let prototype_name = new RegExp($collectionHolder.data('prototype-name'), 'gi');
            newForm = prototype.replace(prototype_name, index);
        }
        else{
            newForm = prototype.replace(/__name__/g, index);
        }
        $collectionHolder.data('index', index + 1);
        let $newFormLi = $(collectionChild).append(newForm);
        $newLink.before($newFormLi);
        addBlockFormDeleteLink($newFormLi);

        return $newFormLi;
    };

    let addBlockFormDeleteLink = function($formLi) {
        let $removeFormA = $(`
            <a href="#" class="btn btn-sm btn-light-danger btn-icon" style="position: absolute; top: 0; right: 0;">
                <i class="fa fa-times"></i>
            </a>
        `);
        $formLi.append($removeFormA);
        $removeFormA.on('click', function(e) {
            e.preventDefault();
            if(!confirmRemove || confirm('Esta seguro de eliminar')) {
                $formLi.remove();
            }
        });
    };

    //* END:CORE HANDLERS *//
    return {
        init: function (collection, confirm = true) {
            confirmRemove = confirm;
            handleEntity($(collection));
        },
    };
}();
