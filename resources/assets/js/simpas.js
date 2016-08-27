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
}
