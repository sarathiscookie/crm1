<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Helvetica, sans-serif;

    }
    table {
        width: 100%;
        font-size: 11px;
        table-layout:fixed;
    }
</style>
<page backtop="30mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="align-content: center;"><img src="{{ public_path() }}/assets/admin/img/invoice_header.png" style="width: 100%;"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="align-content: center; position:absolute; bottom:0px;"><img src="{{ public_path() }}/assets/admin/img/invoice_footer.png" style="width: 100%;"></td>
            </tr>
        </table>
    </page_footer>
    <table style="width: 1000px; padding: 30px 60px; margin-top: 70px;">
        <tr>
            <td style="width: 50%">
                <span style="font-size: 8px; text-decoration: underline;">Registeranzeiger GmbH &bull; Alfons-Auer-Straße 8f &bull; 93053 Regensburg</span><br>
                {!! $invoice['invoice_address'] !!}
            </td>
            <td align="right">
                <span style="font-size: 20px; font-weight: bold;">RECHNUNG</span><br>
                Kundennummer: {{ $invoice['customer_number'] }} <br>
                Rechnungsnummer: {{ $invoice['invoice_number'] }} <br>
                Rech.-/Lieferdatum: {{ $invoice['invoice_date'] }} <br>
                @if(isset($invoice['invoice_due']))
                    Fälligkeitsdatum: {{ $invoice['invoice_due'] }}
                @endif
            </td>
        </tr>
    </table>
    <table style="width: 100%; padding: 30px 60px; border-spacing: 10px; border-collapse: separate; *border-collapse: expression('separate', cellSpacing = '10px');">
        <thead>
        <tr>
            <th align="center" style="padding: 12px;"></th>
            <th align="left" style="width: 270px; padding: 12px;">Artikelbezeichnung</th>
            <th align="center" style="width: 50px; padding: 12px;">Einzelpreis</th>
            <th align="center" style="width: 50px; padding: 12px;">Gesamtpreis</th>
        </tr>
        </thead>
        <tbody>
        {!! $invoice['invoice_order'] !!}
        </tbody>
    </table>
</page>