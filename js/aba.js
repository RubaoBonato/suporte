        var aAbas       = new Array();  // Lista de abas do documento atual
        var sAbaAtiva   = ""                 // Define qual é a aba ativa no momento
        var ABA_ID      = 1
        var ABA_BLOCO   = 2
        var ABA_CAMPOS  = 3

        function defineAba( sId, sBloco ){
           var aAba  = new Array( ABA_CAMPOS );
           aAba[ ABA_ID    ]  = sId;
           aAba[ ABA_BLOCO ]  = sBloco;
           aAbas.push( aAba );
        }

        function defineAbaAtiva( sId ){
           trataCliqueAba( sId );
        }

        function trataMouseAba( oAba ){
           oAba.style.cursor  = "pointer";
        }

        function trataCliqueAba( sId ){
           for ( var iAba  = 0; iAba < aAbas.length; iAba++ ){
              var aAba  = aAbas[ iAba ];

              if   ( aAba[ ABA_ID ] == sId ) ativaAba( aAba );

              else                           inativaAba( aAba );
           }
        }

        function ativaAba( aAba ){
           var sAba       = aAba[ ABA_ID ];
           var oAba       = document.getElementById( sAba );
           mudaClasse( oAba, "abaativa" ); // Esse comando chama a classe css para fazer a troca

           var sBlocoAba  = aAba[ ABA_BLOCO ];
           var oBlocoAba  = document.getElementById( sBlocoAba );
           oBlocoAba.style.display  = "block";
        }

        function inativaAba( aAba ){
           var sAba       = aAba[ ABA_ID ];
           var oAba       = document.getElementById( sAba );
           mudaClasse( oAba, "abainativa" ); // Esse comando chama a classe css para fazer a troca

           var sBlocoAba  = aAba[ ABA_BLOCO ];
           var oBlocoAba  = document.getElementById( sBlocoAba );
           oBlocoAba.style.display  = "none";
        }

        function mudaClasse( oObjeto, sClasse ){
           oObjeto.className  = sClasse;
        }