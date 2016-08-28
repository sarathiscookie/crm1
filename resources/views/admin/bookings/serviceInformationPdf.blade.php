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
<page backtop="20mm" backbottom="10mm" backleft="0mm" backright="0mm">
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
    <table style="width: 1000px; padding: 30px 60px; margin-top: 20px;">
        <tbody>
        <tr>
            <td><h2>Service information</h2></td>
        </tr>

        {!! $position_meta !!}

        </tbody>
    </table>
    <table style="width: 100%; padding: 30px 60px; border-spacing: 10px; border-collapse: separate; *border-collapse: expression('separate', cellSpacing = '10px');">
        <thead>
            <tr>
                <td><h2>Passengers</h2></td>
            </tr>
        </thead>
        <tbody>
        @forelse($passengers as $passenger)
            <tr>
            <td valign="top" align="left" bgcolor="#DDD" style="width:200px; padding: 12px;">{{ title_case($passenger->firstname) }} {{ title_case($passenger->lastname) }}</td>
            </tr>
        @empty
            <tr><td><p>No passengers</p></td></tr>
        @endforelse
        </tbody>
    </table>
</page>