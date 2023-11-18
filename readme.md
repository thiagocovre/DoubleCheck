# Módulo Magento 2 - DigitalHub_DoubleCheck

## Descrição

O módulo `DigitalHub_DoubleCheck` foi desenvolvido para fornecer uma funcionalidade de verificação dupla de alterações nos preços dos produtos no Magento 2.

## Instalação

Clone o repositório para a pasta `app/code/DigitalHub/DoubleCheck` no seu diretório Magento.

   git clone https://github.com/thiagocovre/doublecheck.git 
   
   Estrutura de Pastas
   app/code/DigitalHub/DoubleCheck


## Atualize e ative o módulo.

bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento module:enable DigitalHub_DoubleCheck
bin/magento setup:upgrade

## Limpe o Cache 
bin/magento cache:clean


## Regras do Módulo
Grid de Aprovação de Preços

A grid de aprovação de preços contém as seguintes colunas:

ID: Identificador da tabela
Nome: Nome do usuário solicitante
SKU: SKU do produto
Data: Data e hora da solicitação de alteração
Atributo: Nome do atributo (sempre o atributo price)
Valor anterior: Valor do preço anterior a solicitação
Valor atual: Valor do preço pendente de aprovação
Aprovação: Botão de aprovação
Bloqueio de Modificação de Preço
Ao tentar salvar um produto com alteração no atributo "PRICE", a modificação é bloqueada imediatamente e salva na grid de aprovação de preços para que outro usuário faça a aprovação. Uma vez aprovada, o preço do produto é alterado.

## Aprovação de Preço
A aprovação aplica o novo valor do atributo price no produto em questão.

## CLI (Command Line Interface)
Listar todas as alterações pendentes.
bin/magento digitalhub:price:pending-list

## Aprovar ou reprovar determinada alteração.
bin/magento digitalhub:price:approve 123
bin/magento digitalhub:price:desapprove 123

## Notificação por E-mail 
Sempre que uma alteração de preço for solicitada, um e-mail de aviso é enviado.

## O e-mail do destinatário é configurável.
Existe uma configuração para ativar ou não o envio.
O layout do template e qual template será usado é configurável via painel administrativo.

## UI Component
Foi criada uma área de manipulação da grid com a opção de exportação da grid em CSV e PDF, além de filtros por cada campo criado e opção de edição em linhas.

## Testes Unitários
Testes unitários foram criados para cenários específicos, incluindo a tentativa de alteração de preço e a aprovação do preço.

## Remoção do Módulo
Uma função foi criada para apagar a tabela do banco de dados caso o módulo seja removido.

## Observação Importante
O módulo não proíbe o salvamento da alteração dos demais atributos.


Desde já agradeço pela oportunidade! 

## Thiago Covre
## Dev Sênior Magento







