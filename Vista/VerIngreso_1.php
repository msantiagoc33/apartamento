<!DOCTYPE html>
<!--#################################################################################################
Esta archivo se encarga de ver el  ingreso solicitado con el campo comentario mas grande
##################################################################################################-->
<body>  
    <br><br>
    <div class="container">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th>PLATAFORMA</th><th>HUESPEDES</th><th>ENTRADA</th><th>SALIDA</th><th>IMPORTE</th><th>CLIENTE</th><th>PAIS</th>
                </tr>
            </thead>
            <?php
            foreach ($resultado as $row):
                ?>
                <div class="row">
                    <tr>       
                        <td class="col-1">
                            <select id="plataformaSeleccionada" name="id_plataforma" class="">
                                <option value="0"><?php echo $row->plataforma; ?></option>
                                <?php
                                foreach ($plataformas as $plataforma) {
                                    echo '<option  class="fw-bold text-primary" value="' . $plataforma->id_plataforma . '">' . $plataforma->plataforma . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="text-center col-1"><?php echo $row->huespedes; ?></td>
                        <td class="text-center col-1"><?php echo $row->entrada; ?></td>
                        <td class="text-center col-1"><?php echo $row->salida; ?></td>
                        <td class="text-center col-1"><?php echo $row->importe; ?></td>
                        <td class="text-center col-2"><?php echo $row->cliente; ?></td>
                        <td class="text-center col-2">
                            <select id="plataformaSeleccionada" name="id_pais" class="">
                                <option value="0"><?php echo $row->pais; ?></option>
                                <?php
                                foreach ($paises as $pais) {
                                    echo '<option  class="fw-bold text-primary" value="' . $pais->id_pais . '">' . $pais->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </div>
                <div class="row">
                    <tr>
                        <td class="text-left col-12">
                            <label class="form-label">Comantarios</label>
                            <textarea rows="3" cols="100" >
                                <?php echo $row->comentario; ?> 
                            </textarea>
                        </td>
                    </tr>   
                </div>
            <?php endforeach; ?>
        </table>
        <input type="button" id="volver" value="VOLVER" class="btn btn-primary">
        <input type="button" id="actualizar" value="ACTUALIZAR" class="btn btn-warning">
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $("#volver").click(function (e) {
                $.ajax({
                    url: '?c=paginacionIngresos',
                    success: function (verIngreso) {
                        $("#info").html(verIngreso);
                    },
                    error: function () {
                        $('#info').html("Por favor intentelo de nuevo");
                    }
                });
            });
        });
    </script>
</body>