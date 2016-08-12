class SimPas
{
    constructor()
    {
        this.bootBootstrapUtils();
    }

    bootBootstrapUtils()
    {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    }

    bootSyntaxHighlighting(title, labelOk, labelCancel)
    {
        hljs.initHighlightingOnLoad();

        $('[data-toggle=confirmation]').confirmation({
            'title': `<div class="confirmation-text">${title}</div>`,
            'btnOkLabel': labelOk,
            'btnCancelLabel': labelCancel,
            'btnOkClass': 'btn btn-danger',
            'btnCancelClass': 'btn btn-default',
            'popout': true
        });    
    }
}
