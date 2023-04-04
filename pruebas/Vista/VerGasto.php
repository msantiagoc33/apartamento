<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de ver el  gasto solicitado con el campo comentario mas grande
##################################################################################################-->
<style>
    #cabeceraDetalle{
        margin-bottom: 15px;
        background-color: #07aad0;
        text-align: right;
        color: black;
        padding: 10px 15px 10px 0;
        font-size: 1.3em;
        border-radius: 5px;
    }
</style>
<body>  
    <br><br>
    <div id="cabeceraDetalle">
            <span>Detalle del asiento</span>                
        </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>FECHA</th><th>IMPORTE</th><th>CONCEPTO</th><th>COMENTARIO</th>
                </tr>
            </thead>
            <?php
            foreach ($resultado as $row):
                ?>
                <tr>
                    <td><?php echo $row->fecha; ?></td>
                    <td><?php echo $row->importe; ?></td>
                    <td><?php echo $row->nombre; ?></td>
                </tr>

            <?php endforeach; ?>
        </table>
        <div class="form-floating">
            <textarea class="form-control" style="height: 200px">
                <?php echo $row->comentario; ?> 
            </textarea>
            <label>Comentario</label>
        </div>
        <br><br>
        <input type="button" id="volver" value="VOLVER" class="btn btn-primary">
    </div>
    <script>
        $(document).ready(function () {
            $("#volver").click(function (e) {
                $.ajax({
                    url: '?c=listarGastos',
                    success: function (varGasto) {
                        $("#info").html(varGasto);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
        });
    </script>
</body>