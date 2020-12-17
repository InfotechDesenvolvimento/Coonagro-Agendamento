function desvincular(pedido) {
    element = `<div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Remover Vínculo</h4>
                        </div>
                        <div class="modal-body">
                            <p>Deseja remover esse vínculo de pedido/transportadora?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="../administrador/desvincular/${pedido}">
                                <button type="button" class="btn btn-default">Sim</button>
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        </div>
                        </div>
                        
                    </div>
                </div>`;
    
    $('#voltar').before(element);
    $('#myModal').modal('show');
}