'use strict';

export const getContatos = async () => {
  const url = 'http://localhost/alphacode-backend/index.php/contatos'
  const response = await fetch(url);
  const dados = await response.json();
  console.log(dados);

  return dados;

};

export const insertContato = async (contato) => {
  const url = 'http://localhost/alphacode-backend/index.php/contato'
  const options = {
    headers: {
      "Content-Type": "application/json",
    },
    method: "POST",
    body: JSON.stringify(contato),
  };

  fetch(url, options)
    .then((response) => {
      if (response.ok) {

        return response.json();
      } else {
        throw new Error("Erro ao fazer a solicitação");
      }
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error(error);
    });
};

export const updateContato = async (id, contato) => {
  const url = `http://localhost/alphacode-backend/index.php/contato/${id}`;
  const options = {
    headers: {
      "Content-Type": "application/json",
    },
    method: "PUT",
    body: JSON.stringify(contato),
  };

  fetch(url, options)
    .then((response) => {
      if (response.ok) {

        return response.json();
      } else {
        throw new Error("Erro ao fazer a solicitação");
      }
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error(error);
    });
};

export const deleteContato = async (id) => {
  const url = `http://localhost/alphacode-backend/index.php/contato/${id}`;
  const options = {
    method: "DELETE",
  };

  fetch(url, options);
}
