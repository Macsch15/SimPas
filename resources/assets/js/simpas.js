class SimPas
{
    constructor()
    {
        this.bootBootstrapUtils();
        this.bootSyntaxHighlighting();
    }

    bootBootstrapUtils()
    {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    }

    bootSyntaxHighlighting()
    {
        hljs.initHighlightingOnLoad();
    }

    bootConfirmation(title, labelOk, labelCancel)
    {
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
