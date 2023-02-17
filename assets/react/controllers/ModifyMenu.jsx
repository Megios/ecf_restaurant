import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const ModifyMenu = (props) => {
  const [titre, setTitre] = useState(props.nom);
  const [description, setDescription] = useState(props.description);
  const [prix, setPrix] = useState(props.prix);
  const [ordre, setOrdre] = useState(props.ordre);
  const [toast, setToast] = useState("");
  const [add, setAdd] = useState(false);

  const handleTitreInput = (e) => {
    setTitre(e.target.value);
    setToast("");
  };
  const handleDescriptionInput = (e) => {
    setDescription(e.target.value);
    setToast("");
  };
  const handlePrixInput = (e) => {
    setPrix(e.target.value);
    setToast("");
  };
  const handleOrdreInput = (e) => {
    setOrdre(e.target.value);
    setToast("");
  };
  const handleFerme = (e) => {
    setAdd(false);
  };
  const handleOuvre = (e) => {
    setAdd(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire = {
      Nom: titre,
      Description: description,
      Prix: prix,
      Ordre: ordre,
      Id: props.id,
    };
    if (
      ordre <= 0 ||
      titre === "" ||
      description === "" ||
      !Number.isInteger(parseInt(prix)) ||
      prix <= 0
    ) {
      setToast(false);
    } else {
      axios
        .post("/modifyMenu", formulaire)
        .then(function (response) {
          console.log(response.data.Message);
          setAdd(false);
          window.location.reload(false);
        })
        .catch(function (error) {
          console.log(error);
          setToast(false);
        });
    }
  };

  return (
    <Wrapper>
      {add === true ? (
        <div id="actif">
          <button className="close" onClick={handleFerme}>
            X
          </button>
          <form method="post" acceptCharset="UTF-8">
            <table>
              <thead>
                <tr>
                  <th>
                    <label htmlFor="titre">Titre du menu :</label>
                  </th>
                  <th>
                    <label htmlFor="description">Description :</label>
                  </th>
                  <th>
                    <label htmlFor="Prix">Prix en centimes</label>
                  </th>
                  <th>
                    <label htmlFor="odre">Ordre :</label>
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td data-title="Nom">
                    <input
                      type="text"
                      name="titre"
                      id="titre"
                      defaultValue={props.nom}
                      required
                      onChange={handleTitreInput}
                    />
                  </td>
                  <td data-title="Description">
                    <input
                      type="text"
                      name="description"
                      id="description"
                      defaultValue={props.description}
                      required
                      onChange={handleDescriptionInput}
                    />
                  </td>
                  <td data-title="Prix">
                    <input
                      type="number"
                      name="Prix"
                      id="Prix"
                      required
                      defaultValue={props.prix}
                      onChange={handlePrixInput}
                    />
                  </td>
                  <td data-title="Ordre">
                    <input
                      type="number"
                      name="ordre"
                      id="ordre"
                      required
                      defaultValue={props.ordre}
                      onChange={handleOrdreInput}
                    />
                  </td>
                  <td data-title="Action">
                    <button type="submit" onClick={handleSubmit}>
                      Envoyer
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          {toast === "" ? null : <p>une erreur est survenu</p>}
        </div>
      ) : (
        <button onClick={handleOuvre}>
          Modifier
        </button>
      )}
    </Wrapper>
  );
};

const Wrapper = styled.div`
  #actif {
    position: absolute;
    z-index: 2;
    display: flex;
    flex-direction: column;
    right: 0%;
    top: -2%;
    margin: auto;
    background: hsl(35, 57%, 36%);
    border: 2px solid black;
    .close {
      align-self: end;
      margin: 0px 10px;
    }
    form {
      display: flex;
      flex-direction: column;
      margin: 0;
    }
  }
`;
export default ModifyMenu;
