'use strict';

import { deleteContato, getContatos, insertContato, updateContato } from "./main.js";

const contatos = await getContatos();

const formatarData = (date) => {

    let dataObj = new Date(date);

    let dia = dataObj.getDate() + 1;

    let mes

    if (dataObj.getMonth() > 8) {
        mes = dataObj.getMonth() + 1;
    } else {
        mes = "0" + (dataObj.getMonth() + 1);
    }

    let ano = dataObj.getFullYear();

    return dia + "/" + mes + "/" + ano;

}

const criarCard = (contato) => {
    const trCard = document.createElement('tr');

    const nome = document.createElement('td');
    nome.classList.add('td-text')
    nome.textContent = contato.nome

    const dataNascimento = document.createElement('td');
    dataNascimento.classList.add('td-text')
    dataNascimento.textContent = formatarData(contato.data_nascimento)

    const email = document.createElement('td');
    email.classList.add('td-text')
    email.textContent = contato.email

    const celular = document.createElement('td');
    celular.classList.add('td-text')
    celular.textContent = contato.celular

    const acao = document.createElement('td');
    acao.classList.add('td-text')

    const editar = document.createElement('img');
    editar.src = "../assets/editar.png"
    editar.classList.add('img-action')
    editar.setAttribute("data-bs-toggle", "modal")
    editar.setAttribute("data-bs-target", "#editModal")
    editar.addEventListener('click', () => {

        const nomeModal = document.getElementById('name-edit')
        const emailModal = document.getElementById('email-edit')
        const telefoneModal = document.getElementById('telephone-edit')
        const dataNascimentoModal = document.getElementById('dateOfBirth-edit')
        const profissaoModal = document.getElementById('profession-edit')
        const celularModal = document.getElementById('cellphone-edit')
        let whatsappModal = document.getElementById('checkbox-whatsapp-edit')
        let notificacaoSmsModal = document.getElementById('checkbox-sms-edit')
        let notificacaoEmailModal = document.getElementById('checkbox-email-edit')
        
        nomeModal.value = contato.nome
        dataNascimentoModal.value = contato.data_nascimento
        emailModal.value = contato.email
        profissaoModal.value = contato.profissao
        telefoneModal.value = contato.telefone
        celularModal.value = contato.celular

        if (contato.whatsapp == '1') {
            whatsappModal.checked = true
        }

        if (contato.notificacao_sms == '1') {
            notificacaoSmsModal.checked = true
        }

        if (contato.notificacao_email == '1') {
            notificacaoEmailModal.checked = true
        }

        const buttonEditModal = document.getElementById('buttonEditModal')
        buttonEditModal.addEventListener('click', () => {

            if (whatsappModal.checked) {
                whatsappModal = 1
            } else {
                whatsappModal = 0
            }

            if (notificacaoSmsModal.checked) {
                notificacaoSmsModal = 1
            } else {
                notificacaoSmsModal = 0
            }

            if (notificacaoEmailModal.checked) {
                notificacaoEmailModal = 1
            } else {
                notificacaoEmailModal = 0
            }


            if (
                nomeModal.value == "" || nomeModal.value == null ||
                dataNascimentoModal.value == "" || dataNascimentoModal.value == null ||
                profissaoModal.value == "" || profissaoModal.value == null ||
                telefoneModal.value == "" || telefoneModal.value == null ||
                celularModal.value == "" || celularModal.value == null
            ) {

                Swal.fire({
                    title: "Informação",
                    text: "Campos obrigatórios não foram preenchidos.",
                    icon: "info"
                });

            } else {

                const contatoJSON = {
                    nome: nomeModal.value,
                    email: emailModal.value,
                    telefone: telefoneModal.value,
                    data_nascimento: dataNascimentoModal.value,
                    profissao: profissaoModal.value,
                    celular: celularModal.value,
                    whatsapp: whatsappModal,
                    notificacao_sms: notificacaoSmsModal,
                    notificacao_email: notificacaoEmailModal
                }

                Swal.fire({
                    icon: "success",
                    title: "Contato atualizado com sucesso!",
                    showConfirmButton: false
                });

                updateContato(contato.id, contatoJSON)

                setTimeout(function () {
                    location.reload()
                }, 1500)

            }

        })

    })


    const excluir = document.createElement('img');
    excluir.src = "../assets/excluir.png"
    excluir.classList.add('img-action')
    excluir.addEventListener('click', () => {

        Swal.fire({
            title: "Deseja realmente deletar?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, eu desejo"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteContato(contato.id)
                Swal.fire({
                    title: "Deletado!",
                    text: "Você deletou o contato.",
                    icon: "success"
                });
            }
            setTimeout(function () {
                location.reload();
            }, 2000);
        });
    })

    trCard.append(nome, dataNascimento, email, celular, acao)
    acao.append(editar, excluir)

    return trCard
}

const buttonCadastrar = document.getElementById("btn-cadastrar");

buttonCadastrar.addEventListener('click', () => {
    const nome = document.getElementById("nomeCompleto");
    const dataNascimento = document.getElementById("dataNascimento");
    const email = document.getElementById("email");
    const profissao = document.getElementById("profissao");
    const telefone = document.getElementById("telefone");
    const celular = document.getElementById("celular");

    let whatsapp = document.getElementById("whatsapp");
    if (whatsapp.checked) {
      whatsapp = 1;
    } else {
      whatsapp = 0;
    }

    let notificacaoEmail = document.getElementById("email-notificacao");
    if (notificacaoEmail.checked) {
      notificacaoEmail = 1;
    } else {
      notificacaoEmail = 0;
    }

    let notificacaoSms = document.getElementById("sms-notificacao");
    if (notificacaoSms.checked) {
        notificacaoSms = 1;
    } else {
        notificacaoSms = 0;
    }

    nome.classList.remove("input-error");
    dataNascimento.classList.remove("input-error");
    email.classList.remove("input-error");
    profissao.classList.remove("input-error");
    telefone.classList.remove("input-error");
    celular.classList.remove("input-error");

    if (
        nome.value == "" || nome.value == null ||
        dataNascimento.value == "" || dataNascimento.value == null ||
        profissao.value == "" || profissao.value == null ||
        telefone.value == "" || telefone.value == null ||
        celular.value == "" || celular.value == null
    ) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Campos obrigatórios não foram preenchidos",
        });
    } else {
        const contatoJSON = {
            nome: nome.value,
            data_nascimento: dataNascimento.value,
            email: email.value,
            profissao: profissao.value,
            celular: celular.value,
            telefone: telefone.value,
            whatsapp: whatsapp,
            notificacao_sms: notificacaoSms,
            notificacao_email: notificacaoEmail
        };

        Swal.fire({
            position: "center",
            icon: "success",
            title: "Contato cadastrado com sucesso!",
            showConfirmButton: false,
            timer: 1500
          });

        insertContato(contatoJSON);
        setTimeout(function () {
            location.reload();
        }, 1500);
    }




})


const carregarCard = () => {
    const card = document.getElementById('tbody')
    const cardJson = contatos.contatos.map(criarCard)
    card.replaceChildren(...cardJson)
}

carregarCard()