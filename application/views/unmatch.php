<table id="example" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th></th>
            <th>Nama File</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $file_names_array= explode("\r\n", $list);
            $file_names = array();
            foreach ($file_names_array as $file_name)
            {   
                echo "<tr>";
                echo "<td></td>";
                echo "<td>".$file_name."</td>";
                echo "<td><a href=".site_url()."/report_twp/view/".base64_encode($file_name).">Lihat</a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>