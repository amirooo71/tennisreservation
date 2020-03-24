<template>
    <div ref="container">
        <v-stage ref="stage" :config="stageSize" @mousedown="handleStageMouseDown" @touchstart="handleStageMouseDown">
            <v-layer ref="layer">
                <v-image ref="image" v-for="court in courts" :key="court.id" @transformend="handleTransformEnd" :config="{
                    ...court,
                    image: image,
                    name: 'court' + court.id
                }"/>
                <v-transformer ref="transformer" :config="{
            centeredScaling: true,
            rotationSnaps: [0,90, 180, 270,360],
            }"/>
            </v-layer>
        </v-stage>
    </div>
</template>

<script>
    import Konva from 'konva';
    import VueKonva from 'vue-konva';

    const width = window.innerWidth;
    const height = window.innerHeight;

    export default {
        data() {
            return {
                stageSize: {
                    width: width,
                    height: height
                },
                courts: [
                    {
                        id: 1,
                        rotation: 0,
                        x: 0,
                        y: 10,
                        draggable: true,
                    },
                    {
                        id: 2,
                        rotation: 0,
                        x: 125,
                        y: 10,
                        draggable: true,
                    },
                    {
                        id: 3,
                        rotation: 0,
                        x: 245,
                        y: 10,
                        draggable: true,
                    },
                    {
                        id: 4,
                        rotation: 0,
                        x: 365,
                        y: 10,
                        draggable: true,
                    },
                ],
                selectedCourtId: '',
                image: '',
            };
        },

        created() {
            const image = new window.Image(256,256);
            image.src = "/images/tennis-court-clay.svg";
            image.onload = () => {
                this.image = image;
            };
        },

        mounted() {
            window.addEventListener('resize', this.onWindowResize);

            console.log(this.$refs.image[0]);
        },

        methods: {
            handleTransformEnd(e) {

                // shape is transformed, let us save new attrs back to the node
                // find element in our state
                const rect = this.courts.find(r => r.id === this.selectedCourtId);
                // update the state
                rect.x = e.target.x();
                rect.y = e.target.y();
                rect.rotation = e.target.rotation();
                rect.scaleX = e.target.scaleX();
                rect.scaleY = e.target.scaleY();

                // change fill
                // rect.fill = Konva.Util.getRandomColor();
            },
            handleStageMouseDown(e) {

                // clicked on stage - clear selection
                if (e.target === e.target.getStage()) {
                    this.selectedCourtId = '';
                    this.updateTransformer();
                    return;
                }

                // clicked on transformer - do nothing
                const clickedOnTransformer =
                    e.target.getParent().className === 'Transformer';
                if (clickedOnTransformer) {
                    return;
                }

                // find clicked rect by its name
                const id = e.target.id();

                const court = this.courts.find(r => r.id === id);
                if (court) {
                    this.selectedCourtId = id;
                } else {
                    this.selectedCourtId = '';
                }
                this.updateTransformer();
            },
            updateTransformer() {

                // here we need to manually attach or detach Transformer node
                const transformerNode = this.$refs.transformer.getNode();
                const stage = transformerNode.getStage();
                const {selectedCourtId} = this;

                console.log(stage);


                const selectedNode = stage.findOne('.court' + selectedCourtId);


                console.log(selectedNode);

                // do nothing if selected node is already attached
                if (selectedNode === transformerNode.node()) {
                    return;
                }

                if (selectedNode) {
                    // attach to another node
                    transformerNode.attachTo(selectedNode);
                } else {
                    // remove transformer
                    transformerNode.detach();
                }
                transformerNode.getLayer().batchDraw();
            },

            onWindowResize() {

                let container = this.$refs.container;

                // now we need to fit stage into parent
                let containerWidth = container.offsetWidth;
                // to do this we need to scale the stage
                let scale = containerWidth / this.stageSize.width;

                const stage = this.$refs.stage.getNode();

                stage.width(this.stageSize.width * scale);
                stage.height(this.stageSize.height * scale);
                stage.scale({x: scale, y: scale});
                stage.draw();

            }
        }
    }
    ;
</script>
